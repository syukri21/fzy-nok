<?php

namespace App\Controllers;

use App\Entities\UserEntity;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authorization\AuthorizationException;

class UserManagementController extends BaseController
{
    /**
     * @return RedirectResponse|string
     */
    public function index()
    {
        $user = new UserModel();
        try{
            $data = $user->findAll(10);
            return view('UserManagement/index', ['users'=>$data]);
        }catch (AuthorizationException $e) {
            log_message('error', $e->getMessage());
        }
        return redirect()->back()->with('error',lang('Auth.notEnoughPrivilege'));
    }

    public function add(): string
    {
        return view('UserManagement/add');
    }

    public function create(): RedirectResponse
    {
        $data = $this->request->getPost(['email', 'first_name', 'last_name']);
        try {
            $provider = auth()->getProvider();
            if ($provider->insertWithEmployeeId(new UserEntity($data))) return redirect()->to('/usermanagement/manageuser');
        }catch (\Exception $e){
            log_message('error', $e->getMessage());
        }
        return redirect()->back()->with('error',lang('Auth.notEnoughPrivilege'));
    }
}
