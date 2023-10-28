<?php

namespace App\Controllers;

use App\Entities\ProductionPlan;
use App\Models\ManagerModel;
use App\Models\MasterProductModel;
use App\Models\MasterProductRequirementModel;
use App\Models\OperatorModel;
use App\Models\OperatorProductionModel;
use App\Models\ProductionPlanModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authorization\AuthorizationException;
use Faker\Factory;

class ProductionPlanController extends BaseController
{
    use ResponseTrait;

    /**
     * @return string
     */
    public function index(): string
    {

        $productionPlanOnProgress = new ProductionPlanModel();
        $productionPlanDone = new ProductionPlanModel();
        $productionPlanTodo = new ProductionPlanModel();
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

    public function add(): string
    {
        $faker = Factory::create("id_iD");
        helper('form');

        do {
            $ticket = $faker->regexify('[A-Z]{5}[0-4]{3}');
            $productionPlanModel = new ProductionPlanModel();
            $isExistTicket = $productionPlanModel->isExistTicket($ticket);
        } while ($isExistTicket);

        $forms = [
            'production_ticket' => [
                'title' => 'Ticket Produksi',
                'type' => 'text',
                'name' => 'production_ticket',
                'id' => 'production_ticket',
                'class' => 'form-control',
                'value' => $ticket
            ],
            'quantity' => [
                'title' => 'Kuantitas',
                'type' => 'number',
                'name' => 'quantity',
                'id' => 'quantity',
                'class' => 'form-control',
            ],
            'order_date_show' => [
                'title' => 'Tanggal Order',
                'type' => 'date',
                'name' => 'order_date_show',
                'id' => 'order_date_show',
                'class' => 'form-control',
                'date' => true,
                'value' => date('Y-m-d'),
                'disabled' => true,
            ],
            'order_date' => [
                'title' => 'Tanggal Order',
                'type' => 'hidden',
                'name' => 'order_date',
                'id' => 'order_date',
                'class' => 'form-control',
                'date' => true,
                'value' => date('Y-m-d'),
                'hidden' => true,
            ],
            'due_date' => [
                'title' => 'Tanggal Order',
                'type' => 'date',
                'name' => 'due_date',
                'id' => 'due_date',
                'class' => 'form-control',
                'date' => true,
            ]
        ];

        $masterProductModel = new MasterProductModel();
        $allMasterCode = $masterProductModel->findAll();
        $jsonAllMasterCode = json_encode($allMasterCode);

        $managerModel = new ManagerModel();
        $allManagers = $managerModel->getAllManager();
        $jsonAllManagers = json_encode($allManagers);

        return view("ProductionPlan/add", ['forms' => $forms, 'boms' => $jsonAllMasterCode, 'managers' => $jsonAllManagers]);
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

    public function create()
    {
        $params = $this->request->getPost(["bom", "manager", "production_ticket", "quantity", "order_date", "due_date"]);

        $user = auth()->getUser();

        $data = new ProductionPlan();
        $data->manager_id = $params['manager'];
        $data->master_products_id = $params['bom'];
        $data->production_ticket = $params['production_ticket'];
        $data->quantity = $params['quantity'];
        $data->order_date = $params['order_date'];
        $data->due_date = $params['due_date'];
        $data->ppic_id = $user->id;

        try {
            $productionPlanModel = new ProductionPlanModel();
            $ok = $productionPlanModel->create($data);
            if ($ok) return redirect()->to("production/plan");
        } catch (\ReflectionException $e) {
            log_message('error', $e->getMessage());
            return redirect()->back()->with('error', lang('Internal Server Error'));
        } catch (AuthorizationException $e) {
            log_message('error', $e->getMessage());
        }

        return redirect()->back()->with('error', lang('Auth.notEnoughPrivilege'));


    }

    public function setup()
    {
        $request = $this->request->getGet(["id"]);
        if (empty($request['id'])) return redirect()->back()->with('error', lang("App.invalidArgument", ['attribute' => 'production id']));
        $productionPlanModel = new ProductionPlanModel();
        $data = $productionPlanModel->findProductByProductionPlan($request['id']);

        $operatorModel = new OperatorModel();
        $allOperator = $operatorModel->findAllOperator();
        return view("ProductionPlan/setup", ['data' => $data, 'operators' => json_encode($allOperator)]);
    }

    public function start(): RedirectResponse
    {
        $params = $this->request->getPost(["id", "shift_a_ids", "shift_b_ids"]);
        if (empty($params['id'])) return redirect()->back()->with('error', lang("App.invalidArgument", ['attribute' => 'id']));
        if (empty($params['shift_a_ids'])) return redirect()->back()->with('error', lang("App.invalidArgument", ['attribute' => 'shift a']));
        if (empty($params['shift_b_ids'])) return redirect()->back()->with('error', lang("App.invalidArgument", ['attribute' => 'shift b']));

        $shift_a_ids = json_decode($params['shift_a_ids']);
        $shift_b_ids = json_decode($params['shift_b_ids']);
        foreach ($shift_a_ids as $shift) {
            $shift_a[] = [
                "operator_id" => $shift->id,
                "production_plans_id" => $params['id'],
                "shift" => 0
            ];
        }
        foreach ($shift_b_ids as $shift_b_id) {
            $shift_b[] = [
                "operator_id" => $shift_b_id->id,
                "production_plans_id" => $params['id'],
                "shift" => 1
            ];
        }
        if (empty($shift_a) || empty($shift_b)) return redirect()->back()->with('error', lang("App.invalidArgument", ['attribute' => 'shift']));

        $productionPlanModel = new ProductionPlanModel();
        try {
            $productionPlanModel->setOperators($shift_a, $shift_b);

            $productionPlan = $productionPlanModel->find($params['id']);
            $productionPlan->status = ONPROGRESS;
            $productionPlanModel->save($productionPlan);
            return redirect()->to("production/plan");
        } catch (\Exception $e) {
            log_message("error", $e->getMessage());
        }

        return redirect()->back()->with('error', lang('Auth.notEnoughPrivilege'));
    }
}
