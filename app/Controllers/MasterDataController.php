<?php

namespace App\Controllers;

use App\Models\MasterDataModel;
use CodeIgniter\HTTP\RedirectResponse;

class MasterDataController extends BaseController
{
    private string $path = '/masterdata/managemasterdata';

    /**
     * @return string
     */
    public function index(): string
    {
        $type = $this->request->getGet('type') ?? 'ALL';
        $data = (new MasterDataModel())->findAll(10,0, $type);
        return view('MasterData/MasterData/index', ['data'=>$data]);
    }

    /**
     * @return string
     */
    public function add(): string
    {
        helper('form');
        $forms = [
            'name' => [
                'title' => 'Nama',
                'type' => 'text',
                'name' => 'name',
                'id' => 'name',
                'class' => 'form-control',
            ],
            'type' => [
                'title' => 'Tipe',
                'type' => 'dropdown',
                'name' => 'type',
                'id' => 'type',
                'class' => 'form-select',
            ],
            'weight' => [
                'title' => 'Berat',
                'type' => 'number',
                'name' => 'weight',
                'id' => 'weight',
                'class' => 'form-control',
            ],
            'dimension' => [
                'title' => 'Dimensi',
                'type' => 'text',
                'name' => 'dimension',
                'id' => 'dimension',
                'class' => 'form-control',
            ]

        ];
        return view('MasterData/MasterData/add', ['forms' => $forms]);
    }

    /**
     * @return RedirectResponse|string
     */
    public function edit()
    {

        $data = $this->request->getGet(['id']);
        if (!array_key_exists('id', $data)) return redirect()->back()->with('error', 'ID Karyawan tidak ditemukan');
        $masterdataModel = new MasterDataModel();
        $masterdata = $masterdataModel->findOne($data['id']);
        $forms = [
            'show_id' => [
                'title' => 'ID',
                'disable' => true,
                'type' => 'text',
                'name' => 'show_id',
                'id' => 'show_id',
                'class' => 'form-control',
                'value' => $masterdata->id,

            ],
            'name' => [
                'title' => 'Nama',
                'type' => 'text',
                'name' => 'name',
                'id' => 'name',
                'class' => 'form-control',
                'value' => $masterdata->name,

            ],
            'type' => [
                'title' => 'Tipe',
                'type' => 'dropdown',
                'name' => 'type',
                'id' => 'type',
                'class' => 'form-select',
                'value' => $masterdata->getType(),

            ],
            'weight' => [
                'title' => 'Berat',
                'type' => 'number',
                'name' => 'weight',
                'id' => 'weight',
                'class' => 'form-control',
                'value' => $masterdata->weight,
            ],
            'dimension' => [
                'title' => 'Dimensi',
                'type' => 'text',
                'name' => 'dimension',
                'id' => 'dimension',
                'class' => 'form-control',
                'value' => $masterdata->dimension,
            ],
            'id' => [
                'title' => 'ID',
                'disable' => true,
                'type' => 'hidden',
                'name' => 'id',
                'id' => 'id',
                'class' => 'form-control',
                'value' => $masterdata->id,
            ],
        ];
        helper(['form', 'enum']);
        return view('MasterData/MasterData/edit', ['forms' => $forms]);
    }

    /**
     * @return RedirectResponse|string
     */
    public function create()
    {
        $data = $this->request->getPost(['name', 'weight', 'type', 'dimension']);
        try {
            $masterdataModel = new MasterDataModel();
            if ($masterdataModel->create($data)) return redirect()->to($this->path);
        } catch (\Exception $e) {
            log_message('error', $e);
        }
        return redirect()->back()->with('error', lang('Auth.notEnoughPrivilege'));
    }

    /**
     * @return RedirectResponse|string
     */
    public function update()
    {
        $masterDataModel = new MasterDataModel();
        $data = $this->request->getPost($masterDataModel->getAllowedFields());
        try {
            if ($masterDataModel->update($data['id'], $data)) return redirect()->to($this->path);
        } catch (\Exception $e) {
            log_message('error', $e);
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('error', 'delete failed');
    }

    /**
     * @return RedirectResponse
     */
    public function delete(): RedirectResponse
    {
        $data = $this->request->getGet(['id']);
        try {
            $masterDataModel = new MasterDataModel();
            if ($masterDataModel->delete($data['id'])) return redirect()->to($this->path);
        } catch (\Exception $e) {
            log_message('error', $e);
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('error', 'delete failed');

    }
}
