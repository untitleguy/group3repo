<?php

namespace App\Controllers;

use App\Models\MenuItemModel;

/**
 * Customer-facing shop page.
 */
class Shop extends BaseController
{
    /** Shown in the hero gallery (falls back to the first items). */
    private const HERO_ITEMS = ['MENU-009', 'MENU-027', 'MENU-047'];

    public function index(): string
    {
        $model = model(MenuItemModel::class);
        $items = $model->withStock();

        $byCode = array_column($items, null, 'menu_code');
        $hero   = [];
        foreach (self::HERO_ITEMS as $i => $code) {
            $hero[] = $byCode[$code] ?? ($items[$i] ?? null);
        }

        return view('shop/index', [
            'items'      => $items,
            'categories' => $model->categories(),
            'hero'       => array_filter($hero),
            'maxQty'     => config('Cafe')->maxQuantityPerItem,
        ]);
    }
}
