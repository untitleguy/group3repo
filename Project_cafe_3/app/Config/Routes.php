<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ---------- Shop ----------
$routes->get('/', 'Shop::index');

// ---------- Shop API (JSON) ----------
$routes->post('api/orders', 'Api\Orders::create');

// ---------- Admin ----------
$routes->group('admin', static function (RouteCollection $routes): void {
    $routes->get('login', 'Admin\Auth::login');
    $routes->post('login', 'Admin\Auth::attempt');

    $routes->group('', ['filter' => 'adminAuth'], static function (RouteCollection $routes): void {
        $routes->post('logout', 'Admin\Auth::logout');

        $routes->get('/', 'Admin\Menu::index');
        $routes->get('menu', 'Admin\Menu::index');
        $routes->get('menu/new', 'Admin\Menu::new');
        $routes->post('menu', 'Admin\Menu::create');
        $routes->get('menu/(:segment)/edit', 'Admin\Menu::edit/$1');
        $routes->post('menu/(:segment)', 'Admin\Menu::update/$1');
        $routes->post('menu/(:segment)/delete', 'Admin\Menu::delete/$1');

        $routes->get('orders', 'Admin\Orders::index');
    });
});
