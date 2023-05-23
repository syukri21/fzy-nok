<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController;

class Login extends LoginController
{
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
        if (auth()->loggedIn()){
             auth()->logout();
        }
        return  $this->loginAction();
    }

}