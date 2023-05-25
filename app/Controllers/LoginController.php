<?php

namespace App\Controllers;

use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as BaseLoginController;
use Config\Services;

class LoginController extends BaseLoginController
{
    public static function handleLogin($user)
    {
        $session = Services::session();
        $session->set('user.first_name', $user->getFirstName());
        $session->set('user.last_name', $user->getLastName());
        $session->set('user.email', $user->getEmail());
    }

    public function index(): string
    {
        helper(['form']);
        return view('login/index');
    }

    /**
     * @return RedirectResponse
     * @params null
     */
    public function authenticate(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            auth()->logout();
        }

        $action = $this->loginAction();
        if (auth()->loggedIn()) {
            Events::trigger('login', auth()->user());
        }
        return $action;
    }
}