<?php

namespace App\Controllers;

use App\Models\MasterDataModel;
use App\Models\MasterProductModel;
use CodeIgniter\Files\Exceptions\FileException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authorization\AuthorizationException;

class BillOfMaterialController extends BaseController
{
    protected string $path = '/masterdata/managebom';

    public function index(): string
    {
        [$limit, $offset, $findOptions] = $this->getPageOptions();
        $masterProductModel = new MasterProductModel();
        $data = $masterProductModel->findAll($limit, $offset, $findOptions);
        return view('MasterData/BillOfMaterial/index', ['data' => $data]);
    }

    /**
     * @return string
     */
    public function add(): string
    {
        helper('form');

        $masterData = new MasterDataModel();
        $options = $masterData->findAllOptions();

        $forms = [
            'name' => [
                'title' => 'Nama',
                'type' => 'text',
                'name' => 'name',
                'id' => 'name',
                'class' => 'form-control',
            ],
            'code' => [
                'title' => 'Kode',
                'type' => 'text',
                'name' => 'code',
                'id' => 'code',
                'class' => 'form-control',
            ],
            'price' => [
                'title' => 'Harga',
                'type' => 'number',
                'name' => 'price',
                'id' => 'price',
                'class' => 'form-control',
            ],
            'due_date' => [
                'title' => 'Deadline',
                'type' => 'text',
                'name' => 'due_date',
                'id' => 'due_date',
                'class' => 'form-control datepicker',
                'date' => true,
            ],
            'description' => [
                'title' => 'Deskripsi',
                'type' => 'text',
                'name' => 'description',
                'id' => 'description',
                'class' => 'form-control my-2',
                'style' => 'min-height:100px;',
                'textarea' => true,
            ],
            'image' => [
                'title' => 'Gambar',
                'type' => 'file',
                'name' => 'image',
                'id' => 'image',
                'class' => 'form-control p-2',
                'accept' => 'image/*'
            ]
        ];
        return view('MasterData/BillOfMaterial/add', ['forms' => $forms, 'options' => $options]);
    }

    /**
     * @return RedirectResponse|string
     */
    public function edit()
    {

        $data = $this->request->getGet(['id']);
        if (!array_key_exists('id', $data)) return redirect()->back()->with('error', 'ID Karyawan tidak ditemukan');
        $masterProduct = new MasterProductModel();
        $data = $masterProduct->findOne($data['id']);


        $masterData = new MasterDataModel();
        $options = $masterData->findAllOptions();

        helper('form');
        $forms = [
            'show_id' => [
                'title' => 'ID',
                'disabled' => true,
                'type' => 'text',
                'name' => 'show_id',
                'id' => 'show_id',
                'class' => 'form-control',
                'value' => $data->id,
            ],
            'id' => [
                'title' => 'ID',
                'type' => 'hidden',
                'name' => 'id',
                'id' => 'id',
                'class' => 'form-control',
                'value' => $data->id,
            ],
            'name' => [
                'title' => 'Nama',
                'type' => 'text',
                'name' => 'name',
                'id' => 'name',
                'class' => 'form-control',
                'value' => $data->name
            ],
            'code' => [
                'title' => 'Kode',
                'type' => 'text',
                'name' => 'code',
                'id' => 'code',
                'class' => 'form-control',
                'value' => $data->code,
            ],
            'price' => [
                'title' => 'Harga',
                'type' => 'number',
                'name' => 'price',
                'id' => 'price',
                'class' => 'form-control',
                'value' => $data->price,
            ],
            'due_date' => [
                'title' => 'Deadline',
                'type' => 'text',
                'name' => 'due_date',
                'id' => 'due_date',
                'class' => 'form-control datepicker',
                'value' => $data->due_date->format('m/d/Y'),
                'date' => true,
            ],
            'description' => [
                'title' => 'Deskripsi',
                'type' => 'text',
                'name' => 'description',
                'id' => 'description',
                'class' => 'form-control my-2',
                'value' => $data->description,
                'style' => 'min-height:100px;',
                'textarea' => true,
            ],
            'image' => [
                'title' => 'Gambar',
                'type' => 'file',
                'name' => 'image',
                'id' => 'image',
                'class' => 'form-control p-2',
                'value' => $data->getImageBase64(),
                'accept' => 'image/*'
            ]
        ];
        return view('MasterData/BillOfMaterial/edit', ['forms' => $forms, 'options' => $options]);
    }


    /**
     * @return RedirectResponse|false|string
     */
    public function create()
    {
        $data = $this->request->getPost(['name', 'code', 'price', 'due_date', 'description', 'image', 'requirements']);
        try {
            $masterProductModel = new MasterProductModel();
            if ($imagePath = $this->doUpload()) $data['image'] = $imagePath;
            if (strlen($data['requirements']) != 0) $data['requirements'] = json_decode($data['requirements'], true);
            $id = $masterProductModel->insert($data);
            if (is_int($id)) {
                return $this->redirectResponse(SUCCESS_RESPONSE, "Membuat");
            }
            $err = $masterProductModel->hasError();
        } catch (AuthorizationException $e) {
            log_message('error', $e);
            $err = lang('Auth.notEnoughPrivilege');
        } catch (FileException $e) {
            log_message('error', $e);
            $err = $this->hasError() ?? 'Gagal upload gambar format tidak sesuai';
        } catch (\Exception $e) {
            log_message('error', $e);
            $err = "Something Went Wrong";
        }

        return redirect()->back()->with('error', $err ?? 'Internal Error');
    }


    /**
     * @return RedirectResponse|string
     */
    public function update()
    {
        $masterDataModel = new MasterProductModel();
        $data = $this->request->getPost(['id', 'name', 'code', 'price', 'due_date', 'description', 'image']);
        try {
            if ($imagePath = $this->doUpload()) $data['image'] = $imagePath;
            if ($masterDataModel->update($data['id'], $data)) return $this->redirectResponse(SUCCESS_RESPONSE, "Mengubah");
            $errMsg = $masterDataModel->hasError();
        } catch (FileException $e) {
            log_message('error', $e);
            $errMsg = $this->hasError() ?? "Upload gagal !!!";
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
        $err = "Delete Failed";
        try {
            $masterDataModel = new MasterProductModel();
            if ($masterDataModel->delete($data['id'])) return $this->redirectResponse(SUCCESS_RESPONSE, "Menghapus");
        } catch (\Exception $e) {
            log_message('error', $e);
            $err = "Internal Error";
        }
        return redirect()->back()->with('error', $err);
    }


    private function validateUpload()
    {
        $validateRules = [
            'image' => [
                'rules' => [
                    'uploaded[image]',
                    'max_size[image,2000]',
                    'mime_in[image,image/png,image/jpg,image/gif,image/jpeg]',
                    'ext_in[image,png,jpg,jpeg,gif]',
                    'max_dims[image,2000,2000]',
                ],
            ]
        ];
        if (!$this->validate($validateRules)) {
            throw new FileException();
        };
    }


    public function doUpload(): ?string
    {
        $this->validateUpload();
        $file = $this->request->getFile('image');
        if ($file == null) return null;
        if ($file->getSize() == 0) return null;
        $this->validateUpload();
        return $file->store("masterproducts/");

    }

    /**
     * @return array
     */
    public function getPageOptions(): array
    {
        $limit = 10;
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $limit;
        $options = null;
        return [$limit, $offset, $options];
    }
}

