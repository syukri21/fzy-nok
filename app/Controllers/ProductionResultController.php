<?php

namespace App\Controllers;

use App\Models\ProductionResultModel;
use CodeIgniter\Files\Exceptions\FileException;
use Config\Services;

class ProductionResultController extends BaseController
{
    public function index()
    {
        $data = $this->request->getGet(['production-id']);
        $productionResultModel = new ProductionResultModel();
        $productionResultModel->where('production_id', $data->production_plan_id);
        //
    }

    public function add(): string
    {

        $data = $this->request->getGet(['production-id']);

        helper('form');
        $forms = [
            'qty_produced' => [
                'title' => 'Barang Diterima',
                'type' => 'number',
                'name' => 'qty_produced',
                'id' => 'qty_produced',
                'class' => 'form-control',
            ],
            'qty_rejected' => [
                'title' => 'Barang Reject',
                'type' => 'number',
                'name' => 'qty_rejected',
                'id' => 'qty_rejected',
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
        $data = $this->request->getPost(['qty_produced', 'qty_rejected', 'production_date', 'evidence', 'production_plan_id']);
        $errMsg = "";
        try {
            if ($uploadedPath = $this->doUpload()) $data['evidence'] = $uploadedPath;
            $data['checked_by'] = auth()->getUser()->username;
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


