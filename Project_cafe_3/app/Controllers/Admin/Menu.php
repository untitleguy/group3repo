<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Models\MenuItemModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use Throwable;

/**
 * Admin CRUD for `menu_items` + stock in `inventory`.
 */
class Menu extends BaseController
{
    private MenuItemModel $menu;
    private InventoryModel $inventory;

    public function __construct()
    {
        $this->menu      = model(MenuItemModel::class);
        $this->inventory = model(InventoryModel::class);
    }

    public function index(): string
    {
        $filters = [
            'q'        => trim((string) $this->request->getGet('q')),
            'category' => trim((string) $this->request->getGet('category')),
        ];

        return view('admin/menu/index', [
            'title'      => 'Menu',
            'items'      => $this->menu->withStock($filters),
            'total'      => $this->menu->countAllResults(),
            'categories' => $this->menu->categories(),
            'filters'    => $filters,
        ]);
    }

    public function new(): string
    {
        return $this->form([
            'menu_code'  => $this->menu->nextMenuCode(),
            'category'   => '',
            'menu_name'  => '',
            'style'      => '',
            'price'      => '',
            'unit'       => '',
            'image_path' => '',
            'stock_qty'  => config('Cafe')->defaultStock,
        ], true);
    }

    public function create(): RedirectResponse|string
    {
        $data = $this->input();
        $code = $this->menu->nextMenuCode();

        if (! $this->validateItem($data)) {
            return $this->form(['menu_code' => $code] + $data, true);
        }

        try {
            $this->menu->db->transException(true)->transStart();
            $this->menu->insert(['menu_code' => $code] + $this->itemFields($data));
            $this->inventory->setStock($code, (int) $data['stock_qty']);
            $this->menu->db->transComplete();
        } catch (Throwable $e) {
            log_message('error', 'Menu create failed: {message}', ['message' => $e->getMessage()]);

            return $this->form(['menu_code' => $code] + $data, true, ['Could not save the item. Please try again.']);
        }

        return redirect()->to(site_url('admin/menu'))->with('message', "Added {$code}.");
    }

    public function edit(string $code): string
    {
        return $this->form($this->findOr404($code), false);
    }

    public function update(string $code): RedirectResponse|string
    {
        $this->findOr404($code);
        $data = $this->input();

        if (! $this->validateItem($data)) {
            return $this->form(['menu_code' => $code] + $data, false);
        }

        try {
            $this->menu->db->transException(true)->transStart();
            $this->menu->update($code, $this->itemFields($data));
            $this->inventory->setStock($code, (int) $data['stock_qty']);
            $this->menu->db->transComplete();
        } catch (Throwable $e) {
            log_message('error', 'Menu update failed: {message}', ['message' => $e->getMessage()]);

            return $this->form(['menu_code' => $code] + $data, false, ['Could not save the item. Please try again.']);
        }

        return redirect()->to(site_url('admin/menu'))->with('message', "Updated {$code}.");
    }

    public function delete(string $code): RedirectResponse
    {
        $item = $this->findOr404($code);

        if ($this->menu->hasSales($code)) {
            return redirect()->back()->with('error', "{$code} has sales history, so it can't be deleted. Set its stock to 0 to stop selling it.");
        }

        try {
            $this->menu->db->transException(true)->transStart();
            $this->inventory->delete($code);
            $this->menu->delete($code);
            $this->menu->db->transComplete();
        } catch (Throwable $e) {
            log_message('error', 'Menu delete failed: {message}', ['message' => $e->getMessage()]);

            return redirect()->back()->with('error', "Could not delete {$code}.");
        }

        return redirect()->to(site_url('admin/menu'))->with('message', 'Deleted ' . menu_display_name($item) . " ({$code}).");
    }

    // ------------------------------------------------------------

    private function form(array $item, bool $isNew, array $errors = []): string
    {
        return view('admin/menu/form', [
            'title'      => $isNew ? 'Add menu item' : 'Edit ' . $item['menu_code'],
            'item'       => $item,
            'isNew'      => $isNew,
            'categories' => $this->menu->categories(),
            'errors'     => $errors ?: ($this->validator?->getErrors() ?? []),
        ]);
    }

    private function findOr404(string $code): array
    {
        $item = $this->menu->findWithStock($code);
        if ($item === null) {
            throw PageNotFoundException::forPageNotFound("Menu item {$code} not found.");
        }

        return $item;
    }

    private function input(): array
    {
        $post = fn (string $key): string => trim((string) $this->request->getPost($key));

        return [
            'category'   => $post('category'),
            'menu_name'  => $post('menu_name'),
            'style'      => $post('style'),
            'price'      => $post('price'),
            'unit'       => $post('unit'),
            'image_path' => $post('image_path'),
            'stock_qty'  => $post('stock_qty'),
        ];
    }

    private function validateItem(array $data): bool
    {
        $rules = [
            'category'   => ['label' => 'Category', 'rules' => 'required|max_length[100]'],
            'menu_name'  => ['label' => 'Name', 'rules' => 'required|max_length[150]'],
            'style'      => ['label' => 'Style', 'rules' => 'permit_empty|max_length[50]'],
            'price'      => ['label' => 'Price', 'rules' => 'required|decimal|greater_than_equal_to[0]|less_than[1000000]'],
            'unit'       => ['label' => 'Unit', 'rules' => 'required|max_length[30]'],
            'image_path' => ['label' => 'Image path', 'rules' => 'permit_empty|max_length[255]'],
            'stock_qty'  => ['label' => 'Stock', 'rules' => 'required|is_natural|less_than[1000000]'],
        ];

        return $this->validateData($data, $rules);
    }

    private function itemFields(array $data): array
    {
        return [
            'category'   => $data['category'],
            'menu_name'  => $data['menu_name'],
            'style'      => $data['style'] === '' ? null : $data['style'],
            'price'      => $data['price'],
            'unit'       => $data['unit'],
            'image_path' => $data['image_path'] === '' ? null : $data['image_path'],
        ];
    }
}
