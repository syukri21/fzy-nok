<?php

namespace App\Controllers;

use App\Models\MasterProductModel;
use App\Models\MasterProductRequirementModel;
use App\Models\OperatorProductionModel;
use App\Models\ProductionPlanModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class ProductionPlanController extends BaseController
{
    use ResponseTrait;


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


    public function get(): ResponseInterface
    {
        $data = $this->request->getGet(["id"]);
        if (!array_key_exists('id', $data)) {
            return $this->failValidationErrors("Not found any id");
        }

        $productionPlanModel = new ProductionPlanModel();
        $productionPlan = $productionPlanModel->find($data['id']);

        $userModel = new UserModel();
        $ppic = $userModel->find($productionPlan->ppic_id);
        $manager = $userModel->find($productionPlan->manager_id);

        $masterProductModel = new MasterProductModel();
        $masterProduct = $masterProductModel->find($productionPlan->master_products_id);

        $requirementsModel = new MasterProductRequirementModel();
        $requirements = $requirementsModel->findByMasterProductId($productionPlan->master_products_id);

        $operatorProductionModel = new OperatorProductionModel();
        $operatorProduction = $operatorProductionModel->findOperatorProduction($productionPlan->id);

        return $this->respond([
                "data" => [
                    "productionPlan" => $productionPlan,
                    "ppic" => $ppic,
                    "manager" => $manager,
                    "product" => $masterProduct,
                    "requirements" => $requirements,
                    "operatorProduction" => $operatorProduction
                ]]
        );
    }
}
