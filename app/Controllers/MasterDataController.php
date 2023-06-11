<?php

namespace App\Controllers;

use App\Models\MasterDataModel;
use CodeIgniter\Files\Exceptions\FileException;
use CodeIgniter\HTTP\RedirectResponse;

class MasterDataController extends BaseController
{
    protected string $path = '/masterdata/managemasterdata';

    /**
     * @return string
     */
    public function index(): string
    {
        [$limit, $offset, $type] = $this->getPageInfo();
        $data = (new MasterDataModel())->findAll($limit, $offset, $type);
        return view('MasterData/MasterData/index', ['data' => $data]);
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
            ],
            'masterdataimagefile' => [
                'title' => 'Gambar',
                'type' => 'file',
                'name' => 'masterdataimagefile',
                'id' => 'masterdataimagefile',
                'class' => 'form-control p-2',
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
                'disabled' => true,
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
                'type' => 'hidden',
                'name' => 'id',
                'id' => 'id',
                'class' => 'form-control',
                'value' => $masterdata->id,
            ],
            'masterdataimagefile' => [
                'title' => 'Gambar',
                'type' => 'file',
                'name' => 'masterdataimagefile',
                'id' => 'masterdataimagefile',
                'class' => 'form-control p-2',
                'value' => $masterdata->getImageBase64(),
                'onchange' => 'editMasterData(this)'
            ]
        ];
        helper(['form', 'enum']);
        return view('MasterData/MasterData/edit', ['forms' => $forms]);
    }

    /**
     * @return RedirectResponse|string
     */
    public function create()
    {
        $masterdataModel = new MasterDataModel();
        $data = $this->request->getPost(['name', 'weight', 'type', 'dimension']);
        $errMsg = "";
        try {
            if ($uploadedPath = $this->doUpload()) $data['image'] = $uploadedPath;
            if ($masterdataModel->create($data)) return $this->redirectResponse(SUCCESS_RESPONSE, "Membuat");
        } catch (FileException $e) {
            log_message('error file upload', $e);
            $errMsg = "Gagal upload gambar format tidak sesuai.";
        } catch (\Exception $e) {
            log_message('error', $e);
            $errMsg = lang('Auth.notEnoughPrivilege');
        }
        return redirect()->back()->with('error', $errMsg);
    }

    /**
     * @return RedirectResponse|string
     */
    public function update()
    {
        $masterDataModel = new MasterDataModel();
        $data = $this->request->getPost(['id', 'type', 'name', 'weight', 'dimension', 'masterdata_type']);
        $errMsg = "";
        try {
            if($uploadedPath = $this->doUpload()) $data['image'] = $uploadedPath;
            if ($masterDataModel->update($data['id'], $data)) return $this->redirectResponse(SUCCESS_RESPONSE, "Mengubah");
        } catch (FileException $e) {
            log_message('error', $e);
            $errMsg = "Gagal upload gambar format tidak sesuai.";
        } catch (\Exception $e) {
            log_message('error', $e);
            $errMsg = lang('Auth.notEnoughPrivilege');
        }

        return redirect()->back()->with('error', $errMsg);
    }

    /**
     * @return RedirectResponse
     */
    public function delete(): RedirectResponse
    {
        $data = $this->request->getGet(['id']);
        try {
            $masterDataModel = new MasterDataModel();
            if ($masterDataModel->delete($data['id'])) return $this->redirectResponse(SUCCESS_RESPONSE, "Menghapus");
        } catch (\Exception $e) {
            log_message('error', $e);
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('error', 'delete failed');
    }

    /**
     * @return string uploaded path
     */
    public function doUpload(): ?string
    {
        $validateRules = [
            'masterdataimagefile' => [
                'rules' => [
                    'uploaded[masterdataimagefile]',
                    'max_size[masterdataimagefile,2000]',
                    'mime_in[masterdataimagefile,image/png,image/jpg,image/gif,image/jpeg]',
                    'ext_in[masterdataimagefile,png,jpg,jpeg,gif]',
                    'max_dims[masterdataimagefile,2000,2000]',
                ],
            ]
        ];
        if (!$this->validate($validateRules)) throw new FileException();
        $file = $this->request->getFile('masterdataimagefile');
        if ($file->getSize() == 0) {
            return null;
        }

        if (!$path = $file->store('masterdata/')) {
            throw new FileException();
        }
        return $path;
    }

    /**
     * @return array
     */
    public function getPageInfo(): array
    {
        $limit = 10;
        $type = $this->request->getGet('type') ?? 'ALL';
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $limit;
        return [$limit, $offset, $type];
    }
}
