<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as BaseLogoutController;

class LogoutController extends BaseLogoutController
{
    public function index(): RedirectResponse
    {
        return $this->logoutAction();
    }
}
