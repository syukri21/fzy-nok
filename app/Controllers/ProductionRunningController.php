<?php

namespace App\Controllers;

use App\Models\OperatorModel;
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
            $production = $operatorModel->findRunningProductionByOperatorId($id);
        } elseif (in_array('manager', $groups)) {
            // TODO add find runningProduction
        } elseif (in_array('ppic', $groups)) {
            // TODO add find runningProduction
        }

        $data = [
            "production" => $production
        ];

        return view('Production/index', $data);
    }


}
