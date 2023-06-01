<?php

namespace App\Controllers;

use App\Entities\UserEntity;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authorization\AuthorizationException;

/**
 *
 */
class UserManagementController extends BaseController
{
    /**
     * @return RedirectResponse|string
     */
    public function index()
    {
        $user = new UserModel();
        try {
            $data = $user->findAll(10);
            return view('UserManagement/index', ['users' => $data]);
        } catch (AuthorizationException $e) {
            log_message('error', $e->getMessage());
        }
        return redirect()->back()->with('error', lang('Auth.notEnoughPrivilege'));
    }

    /**
     * @return string
     */
    public function add(): string
    {
        return view('UserManagement/add');
    }

    /**
     * @return RedirectResponse|string
     */
    public function edit()
    {

        $data = $this->request->getGet(['employee_id']);
        if (!array_key_exists('employee_id', $data)) return redirect()->back()->with('error', 'ID Karyawan tidak ditemukan');
        $user = (new UserModel())->findOne($data['employee_id']);

        helper('form');
        $forms = [
            'email' => [
                'title' => 'Email',
                'type' => 'email',
                'name' => 'email',
                'id' => 'email',
                'value' => $user->email,
                'class' => 'form-control',
            ],
            'username' => [
                'disabled' => true,
                'title' => 'NIK',
                'type' => 'text',
                'name' => 'username',
                'id' => 'username',
                'value' => $user->username,
                'class' => 'form-control',
            ],
            'first_name' => [
                'title' => 'First Name',
                'type' => 'text',
                'name' => 'first_name',
                'id' => 'first_name',
                'value' => $user->first_name,
                'class' => 'form-control',
            ],
            'last_name' => [
                'title' => 'Last Name',
                'type' => 'text',
                'name' => 'last_name',
                'id' => 'last_name',
                'value' => $user->last_name,
                'class' => 'form-control',
            ],
            'password' => [
                'title' => 'Code Confirmation',
                'type' => 'text',
                'name' => 'confirmation_code',
                'id' => 'confirmation_code',
                'value' => $user->confirmation_code,
                'class' => 'form-control',
            ],
            'employeeId' => [
                'title' => 'Employee ID',
                'type' => 'hidden',
                'name' => 'employee_id',
                'id' => 'employee_id',
                'value' => $user->username,
                'class' => 'form-control',
            ],
        ];
        return view('UserManagement/edit', ['forms' => $forms]);
    }

    /**
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {
        $data = $this->request->getPost(['email', 'first_name', 'last_name']);
        try {
            $provider = auth()->getProvider();
            if ($provider->insertWithEmployeeId(new UserEntity($data))) return redirect()->to('/usermanagement/manageuser');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
        }
        return redirect()->back()->with('error', lang('Auth.notEnoughPrivilege'));
    }

    /**
     * @return RedirectResponse
     */
    public function delete(): RedirectResponse
    {
        $data = $this->request->getGet(['employee_id']);
        try {
            if (!array_key_exists('employee_id', $data)) {
                return redirect()->back()->with('error', 'ID Karyawan tidak ditemukan');
            }
            (new UserModel())->deleteByEmployeeId($data['employee_id']);
            return redirect()->to('/usermanagement/manageuser');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
        }
        return redirect()->back()->with('error', lang('Auth.notEnoughPrivilege'));
    }

    /**
     * @return RedirectResponse|string
     */
    public function update()
    {
        try {
            $data = $this->request->getPost(['email', 'first_name', 'last_name', 'employee_id', 'confirmation_code']);
            (new UserModel())->updateByEmployeeId($data['employee_id'], $data);
            return redirect()->to('/usermanagement/manageuser');
        }catch (\Exception $e){
            log_message('error', $e);
        }

        return redirect()->back()->with('error', lang('Auth.notEnoughPrivilege'));
    }


}
