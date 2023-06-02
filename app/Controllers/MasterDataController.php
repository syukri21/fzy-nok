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
    public function index()
    {
        $data = (new MasterDataModel())->findAll(10);
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
                'type' => 'text',
                'name' => 'type',
                'id' => 'type',
                'class' => 'form-control',
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
     * TODO add feature MasterData Update
     * @return void
     *
     */
    public function update()
    {

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
