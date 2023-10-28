<?php

namespace App\Controllers;

use App\Models\OperatorModel;
use App\Models\ProductionPlanModel;
use App\Models\ProductionResultModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Files\Exceptions\FileException;
use CodeIgniter\HTTP\RedirectResponse;

class ProductionResultController extends BaseController
{
    protected string $path = "/production/result";

    public function index(): string
    {
        $request = $this->request->getGet(['production-id', 'limit', 'offset']);
        $limit = 10;
        $offset = 0;
        if (!empty($request["limit"])) $limit = intval($request['limit']);
        if (!empty($request["offset"])) $offset = intval($request['offset']);

        try {
            $production_id = $this->getProductionId();
            $productionPlanModel = new ProductionPlanModel();
            $productionPlan = $productionPlanModel->find($production_id);

            $groups = auth()->getUser()->getGroups();

            if (in_array("operator", $groups)) {
                $productionResultModel = new ProductionResultModel();
                $data = $productionResultModel->findAllOperatorProductionResult($production_id, $limit, $offset);
            } elseif (in_array("manager", $groups)) {
                $productionResultModel = new ProductionResultModel();
                $data = $productionResultModel->findAllManagerProductionResult($production_id, $limit, $offset);
            } elseif (in_array("ppic", $groups)) {
                $productionResultModel = new ProductionResultModel();
                $data = $productionResultModel->findAllPPICProductionResult($production_id, $limit, $offset);
            } else {
                $data = [];
            }
        } catch (DataException $exception) {
            log_message("info", "no production running");
            return view('ProductionResult/index', ['empty' => true]);
        }


        return view('ProductionResult/index', [
            'data' => $data,
            'production_id' => $production_id,
            'production_ticket' => $productionPlan->production_ticket,
            'empty' => false
        ]);
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

    /**
     * @return string
     */
    public function edit(): string
    {
        helper('form');

        $id = $this->request->getGet(['id']);
        $productionResultModel = new ProductionResultModel();
        $data = $productionResultModel->where("id", $id)->first();
        $forms = [
            'quantity_produced' => [
                'title' => 'Barang Diterima',
                'type' => 'number',
                'name' => 'quantity_produced',
                'id' => 'quantity_produced',
                'class' => 'form-control',
                'value' => $data->quantity_produced,
            ],
            'quantity_rejected' => [
                'title' => 'Barang Reject',
                'type' => 'number',
                'name' => 'quantity_rejected',
                'id' => 'quantity_rejected',
                'class' => 'form-control',
                'value' => $data->quantity_rejected,
            ],
            'production_date_show' => [
                'title' => 'Tanggal Produksi',
                'type' => 'datetime-local',
                'name' => 'production_date_show',
                'id' => 'production_date_show',
                'class' => 'form-control',
                'date' => true,
                'value' => $data->production_date->format('Y-m-d\TH:i'),
                'disabled' => true,
            ],
            'production_date' => [
                'title' => 'Tanggal Produksi',
                'type' => 'hidden',
                'name' => 'production_date',
                'id' => 'production_date',
                'class' => 'form-control',
                'date' => true,
                'value' => $data->production_date->format('Y-m-d\TH:i'),
                'hidden' => true,
            ],
            'evidence' => [
                'title' => 'Bukti Gambar',
                'type' => 'file',
                'name' => 'evidence',
                'id' => 'evidence',
                'class' => 'form-control p-2',
                'onchange' => "onChangeImage(this)",
                "src" => "/uploads/" . json_decode($data->evidence)[0]
            ],
            'production_plan_id' => [
                'title' => 'Production Plan Id',
                'type' => 'hidden',
                'name' => 'production_plan_id',
                'id' => 'production_plan_id',
                'hidden' => true,
                'value' => $data->production_plan_id,
            ],
            'id' => [
                'title' => 'ID',
                'type' => 'hidden',
                'name' => 'id',
                'id' => 'id',
                'hidden' => true,
                'value' => $data->id,
            ]
        ];
        return view('ProductionResult/edit', ['forms' => $forms]);
    }

    public function create(): RedirectResponse
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

    public function update(): RedirectResponse
    {
        $productionResultModel = new ProductionResultModel();
        $data = $this->request->getPost(['id', 'quantity_rejected', 'quantity_produced', 'production_date', 'evidence', 'production_plan_id']);
        $errMsg = "";
        try {
            if ($uploadedPath = $this->doUpload()) $data['evidence'] = json_encode([$uploadedPath]);
            $data['reported_by'] = auth()->getUser()->username;
            if ($productionResultModel->update($data['id'], $data)) return $this->redirectResponse(SUCCESS_RESPONSE, "Mengupdate");
        } catch (FileException $e) {
            log_message('error', $e);
            $errMsg = "Gagal upload evidence format tidak sesuai.";
        } catch (\Exception $e) {
            log_message('error', $e);
            $errMsg = lang('Auth.notEnoughPrivilege');
        }

        return redirect()->back()->with('error', $errMsg);
    }

    public function delete(): RedirectResponse
    {
        $request = $this->request->getGet(['id']);
        if (empty($request['id'])) {
            return redirect()->back()->with('error', 'ID not found.');
        }
        try {
            $productionResultModel = new ProductionResultModel();
            if ($productionResultModel->delete($request['id'])) return $this->redirectResponse(SUCCESS_RESPONSE, "Menghapus");
        } catch (\Exception $e) {
            log_message('error', $e);
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('error', 'delete failed');
    }

    public function approve(): RedirectResponse
    {
        $request = $this->request->getGet(['id']);
        if (empty($request['id'])) {
            return redirect()->back()->with('error', 'ID not found.');
        }

        try {
            $productionResultModel = new ProductionResultModel();
            $username = auth()->getUser()->username;
            if ($productionResultModel->update($request['id'], ["checked_by" => $username])) return $this->redirectResponse(SUCCESS_RESPONSE, "approve");
        } catch (\Exception $e) {
            log_message('error', $e);
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('error', 'approve failed');

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

    /**
     * @return mixed
     */
    public function getProductionId()
    {
        $request = $this->request->getGet(['production-id']);
        $production_id = $request['production-id'];
        if (empty($production_id)) {
            $operatorModel = new OperatorModel();
            $production = $operatorModel->findRunningProductionById(auth()->getUser()->id);
            $production_id = $production->id;
        }
        return $production_id;
    }
}


