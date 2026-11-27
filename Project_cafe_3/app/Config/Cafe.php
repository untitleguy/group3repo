<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Kaffee & Co. settings.
 *
 * Every value can be overridden in .env, e.g.
 *   cafe.adminUsername = admin
 *   cafe.adminPassword = choose-a-strong-password
 */
class Cafe extends BaseConfig
{
    /** Admin login name. */
    public string $adminUsername = 'admin';

    /**
     * Admin password. Leave empty to keep the admin area locked;
     * set it in .env (cafe.adminPassword), not in this file.
     */
    public string $adminPassword = '';

    /** Stock given to a menu item that has no inventory row yet. */
    public int $defaultStock = 10;

    /** Folder (inside public/) that menu_items.image_path is relative to. */
    public string $menuImageFolder = 'assets/menu/';

    /** Largest quantity of one item allowed in a single order. */
    public int $maxQuantityPerItem = 99;

    /** Orders shown per page in the admin. */
    public int $ordersPerPage = 20;
}
