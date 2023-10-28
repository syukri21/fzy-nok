<?php

namespace App\Controllers;

use App\Models\ProductionResultModel;

class HomeController extends BaseController
{
    public function index(): string
    {
        $productionResultModel = new ProductionResultModel();
        $monthProduction = $productionResultModel->getMonthProduction();

        $allTime = $productionResultModel->getAllTimeProduction();


        return view("Dashboard/index.php", ["allTime" => $allTime, "month" => $monthProduction]);
    }
}
