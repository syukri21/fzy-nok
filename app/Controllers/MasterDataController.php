<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MasterDataController extends BaseController
{
    public function index()
    {
        return view('MasterData/MasterData/index');
    }
}
