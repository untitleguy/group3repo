<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Admin login / logout. Credentials: Config\Cafe (set them in .env).
 */
class Auth extends BaseController
{
    public function login(): RedirectResponse|string
    {
        if (session()->get('isAdmin') === true) {
            return redirect()->to(site_url('admin'));
        }

        return view('admin/login', [
            'disabled' => config('Cafe')->adminPassword === '',
        ]);
    }

    public function attempt(): RedirectResponse
    {
        $config   = config('Cafe');
        $username = (string) $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');

        if ($config->adminPassword === '') {
            return redirect()->back()->with('error', 'Admin login is disabled until cafe.adminPassword is set in .env.');
        }

        $ok = hash_equals($config->adminUsername, $username)
            && hash_equals($config->adminPassword, $password);

        if (! $ok) {
            return redirect()->back()->withInput()->with('error', 'Wrong username or password.');
        }

        session()->regenerate(true);
        session()->set('isAdmin', true);

        return redirect()->to(site_url('admin'));
    }

    public function logout(): RedirectResponse
    {
        session()->remove('isAdmin');
        session()->regenerate(true);

        return redirect()->to(site_url('admin/login'))->with('message', 'You have been logged out.');
    }
}
