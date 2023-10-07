<?php

namespace App\Controllers;

use App\Models\OperatorModel;
use App\Models\ProductionPlanModel;
use App\Models\ProductionResultModel;
use CodeIgniter\Files\Exceptions\FileException;

class ProductionResultController extends BaseController
{
    protected string $path = "/production/result";
    public function index()
    {
        $request = $this->request->getGet(['production-id', 'limit', 'offset']);
        $production_id = $request['production-id'];
        $limit = 10;
        $offset = 0;
        if (!empty($request["limit"])) $limit = intval($request['limit']);
        if (!empty($request["offset"])) $offset = intval($request['offset']);

        if (empty($production_id)) {
            $operatorModel = new OperatorModel();
            $production = $operatorModel->findRunningProductionByOperatorId(auth()->getUser()->id);
            $production_id = $production->id;
        }

        $productionPlanModel = new ProductionPlanModel();
        $productionPlan = $productionPlanModel->find($production_id);

        $productionResultModel = new ProductionResultModel();
        $data = $productionResultModel->findAllOperatorProductionResult($production_id, $limit, $offset);

        return view('ProductionResult/index', ['data' => $data, 'production_id' => $production_id, 'production_ticket' => $productionPlan->production_ticket]);
    }

    public function add(): string
    {

        $data = $this->request->getGet(['production-id']);

        helper('form');
        $forms = [
            'quantity_produced' => [
                'title' => 'Barang Diterima',
                'type' => 'number',
                'name' => 'quantity_produced',
                'id' => 'quantity_produced',
                'class' => 'form-control',
            ],
            'quantity_rejected' => [
                'title' => 'Barang Reject',
                'type' => 'number',
                'name' => 'quantity_rejected',
                'id' => 'quantity_rejected',
                'class' => 'form-control',
            ],
            'production_date_show' => [
                'title' => 'Tanggal Produksi',
                'type' => 'date',
                'name' => 'production_date_show',
                'id' => 'production_date_show',
                'class' => 'form-control',
                'date' => true,
                'value' => date('Y-m-d'),
                'disabled' => true,
            ],
            'production_date' => [
                'title' => 'Tanggal Produksi',
                'type' => 'hidden',
                'name' => 'production_date',
                'id' => 'production_date',
                'class' => 'form-control',
                'date' => true,
                'value' => date('Y-m-d'),
                'hidden' => true,
            ],
            'evidence' => [
                'title' => 'Bukti Gambar',
                'type' => 'file',
                'name' => 'evidence',
                'id' => 'evidence',
                'class' => 'form-control p-2',
                'onchange' => "onChangeImage(this)"
            ],
            'production_plan_id' => [
                'title' => 'Production Plan Id',
                'type' => 'hidden',
                'name' => 'production_plan_id',
                'id' => 'production_plan_id',
                'hidden' => true,
                'value' => $data['production-id']
            ]
        ];
        return view('ProductionResult/add', ['forms' => $forms]);
    }

    public function create()
    {
        $productionResultModel = new ProductionResultModel();
        $data = $this->request->getPost(['quantity_rejected', 'quantity_produced', 'production_date', 'evidence', 'production_plan_id']);
        $errMsg = "";
        try {
            if ($uploadedPath = $this->doUpload()) {
                $data['evidence'] = json_encode([$uploadedPath]);
            }
            $data['reported_by'] = auth()->getUser()->username;
            if ($productionResultModel->save($data)) return $this->redirectResponse(SUCCESS_RESPONSE, "Membuat");
        } catch (FileException $e) {
            log_message('error', $e);
            $errMsg = "Gagal upload evidence format tidak sesuai.";
        } catch (\Exception $e) {
            log_message('error', $e);
            $errMsg = lang('Auth.notEnoughPrivilege');
        }

        return redirect()->back()->with('error', $errMsg);
    }


    public function doUpload(): ?string
    {
        $validateRules = [
            'evidence' => [
                'rules' => [
                    'uploaded[evidence]',
                    'max_size[evidence,2000]',
                    'mime_in[evidence,image/png,image/jpg,image/gif,image/jpeg]',
                    'ext_in[evidence,png,jpg,jpeg,gif]',
                    'max_dims[evidence,2000,2000]',
                ],
            ]
        ];
        if (!$this->validate($validateRules)) throw new FileException();
        $file = $this->request->getFile('evidence');
        if ($file->getSize() == 0) {
            return null;
        }

        if (!$path = $file->store('evidences/')) {
            throw new FileException();
        }
        return $path;
    }
}


