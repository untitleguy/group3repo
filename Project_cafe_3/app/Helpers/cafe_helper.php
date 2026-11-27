<?php

/**
 * Kaffee & Co. view helpers. Loaded by BaseController ($helpers = [..., 'cafe']).
 */

if (! function_exists('format_baht')) {
    /** 50 → "฿50", 59.5 → "฿59.50" */
    function format_baht($amount): string
    {
        $amount = (float) $amount;
        $decimals = floor($amount) == $amount ? 0 : 2;

        return '฿' . number_format($amount, $decimals);
    }
}

if (! function_exists('menu_display_name')) {
    /** "ลาเต้ (เย็น)" — name plus style when the item has one. */
    function menu_display_name(array $item): string
    {
        $style = trim((string) ($item['style'] ?? ''));

        return $style === '' ? $item['menu_name'] : $item['menu_name'] . ' (' . $style . ')';
    }
}

if (! function_exists('menu_image_url')) {
    /**
     * URL for menu_items.image_path. Relative paths are resolved inside
     * public/assets/menu/ (Config\Cafe::$menuImageFolder); full URLs pass through.
     */
    function menu_image_url(?string $path): string
    {
        $path = trim((string) $path);
        if ($path === '') {
            return '';
        }
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $segments = array_map('rawurlencode', explode('/', ltrim(str_replace('\\', '/', $path), '/')));

        return base_url(config('Cafe')->menuImageFolder . implode('/', $segments));
    }
}
