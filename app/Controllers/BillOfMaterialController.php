<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BillOfMaterialController extends BaseController
{
    public function index()
    {
        return view('MasterData/BillOfMaterial/index');
    }
}
