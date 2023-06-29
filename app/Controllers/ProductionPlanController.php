<?php

namespace App\Controllers;

use App\Models\ProductionPlanModel;

class ProductionPlanController extends BaseController
{


    /**
     * @return string
     */
    public function index(): string
    {

        $productionPlanTodo = new ProductionPlanModel();
        $productionPlanOnProgress = new ProductionPlanModel();
        $productionPlanDone = new ProductionPlanModel();
        $data = [
            "todo" => [
                "data" => $productionPlanTodo->findAllTodo(10),
                "pager" => $productionPlanTodo->pager,
            ],
            "onProgress" => [
                "data" => $productionPlanOnProgress->findAllOnProgress(10),
                "pager" => $productionPlanOnProgress->pager,
            ],
            "done" => [
                "data" => $productionPlanDone->findAllDone(10),
                "pager" => $productionPlanDone->pager,
            ]
        ];

        return view('ProductionPlan/index', $data);
    }
}
