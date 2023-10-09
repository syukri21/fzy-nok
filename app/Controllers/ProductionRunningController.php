<?php

namespace App\Controllers;

use App\Models\ManagerModel;
use App\Models\OperatorModel;
use App\Models\PPICModel;
use CodeIgniter\API\ResponseTrait;

class ProductionRunningController extends BaseController
{

    use ResponseTrait;

    /**
     * @return string
     */
    public function index(): string
    {

        $production = new \stdClass();
        $groups = auth()->getUser()->getGroups();
        $id = auth()->getUser()->id;
        if (in_array('operator', $groups)) {
            $operatorModel = new OperatorModel();
            $production = $operatorModel->findRunningProductionById($id);
        } elseif (in_array('manager', $groups)) {
            $managerModel = new ManagerModel();
            $production = $managerModel->findRunningProductionById($id);
        } elseif (in_array('ppic', $groups)) {
            $model = new PPICModel();
            $production = $model->findRunningProductionById($id);
        } else {
            // TODO add find runningProduction
        }

        $data = [
            "production" => $production
        ];

        return view('Production/index', $data);
    }


}
