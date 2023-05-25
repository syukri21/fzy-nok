<?php

namespace App\Controllers;

class UserManagementController extends BaseController
{
    public function index()
    {
        return view('UserManagement/index');
    }
}
