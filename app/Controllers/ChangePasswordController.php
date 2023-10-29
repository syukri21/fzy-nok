<?php

namespace App\Controllers;

class ChangePasswordController extends BaseController
{
    public function index(): string
    {
        return view('ChangePassword/index');
    }

}