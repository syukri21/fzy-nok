<?php

namespace App\Controllers;

use App\Models\ManagerModel;
use App\Models\OperatorModel;
use App\Models\PPICModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authorization\AuthorizationException;

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
        try {
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
        } catch (DataException $exception) {
            log_message("info", "no production running");
            return view('Production/index', ['empty' => true]);
        }

        $data = [
            "production" => $production,
            'empty' => false
        ];

        return view('Production/index', $data);
    }

    public function done(): RedirectResponse
    {

        $request = $this->request->getPost(["production_id"]);
        if (empty($request['production_id'])) return redirect()->back()->with('error', lang("App.invalidArgument", ['attribute' => 'production id']));

        try {
            $managerModel = new ManagerModel();
            $managerModel->finishRunningProductionById($request['production_id']);
            return redirect()->to("/production/plan");
        } catch (AuthorizationException|\ReflectionException $e) {
            log_message('error', $e->getMessage());
        }

        return redirect()->back()->with('error', lang('Auth.notEnoughPrivilege'));
    }


}
