<?php

namespace App\Controllers;

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
            ]
        ];
        return view('MasterData/BillOfMaterial/add', ['forms' => $forms]);
    }


    /**
     * @return RedirectResponse|false|string
     */
    public function create()
    {
        $data = $this->request->getPost(['name', 'code', 'price', 'due_date', 'description', 'image']);
        try {
            $masterProductModel = new MasterProductModel();
            $this->validateUpload();
            $id = $masterProductModel->withUpload($this->request->getFile('image'))->insert($data);
            if (is_int($id)) {
                return $this->redirectResponse(SUCCESS_RESPONSE, "Membuat");
            }
            $err = $masterProductModel->hasError();
        } catch (AuthorizationException $e) {
            log_message('error', $e);
            $err = lang('Auth.notEnoughPrivilege');
        } catch (FileException $e) {
            log_message('error', $e);
            $err = 'Gagal upload gambar format tidak sesuai';
        } catch (\Exception $e) {
            log_message('error', $e);
            $err = "Something Went Wrong";
        }

        return redirect()->back()->with('error', $err ?? 'Internal Error');
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
                    'max_dims[image,2000,800]',
                ],
            ]
        ];
        if (!$this->validate($validateRules)) throw new FileException();
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

