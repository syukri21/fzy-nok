<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Database\ResultInterface;
use CodeIgniter\Shield\Authorization\AuthorizationException;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;
use Config\Database;

/**
 *
 */
class UserModel extends ShieldUserModel
{
    protected $returnType = UserEntity::class;

    protected function initialize(): void
    {
        parent::initialize();
        $this->allowedFields = [
            ...$this->allowedFields,
            'employee_id',
            'first_name',
            'last_name',
            'confirmation_code'
        ];
    }

    /**
     * @param UserEntity ...$entities
     * @return bool|int
     */
    public function batchInsert(UserEntity ...$entities)
    {
        auth()->user()->can('user.create');
        $number = $this->getNextEmployeeIdLastNumber();
        foreach ($entities as $key => $entity) {
            $entity->setUsername($number);
            $entity->generateRandomPassword();
            $entities[$key] = $entity;
        }
        return $this->doInsertBatch($entities);
    }

    /**
     * @param UserEntity $entity
     * @return int|string|true
     */
    public function insertWithEmployeeId(UserEntity $entity)
    {
        if (!auth()->user()->can('users.create')) throw new AuthorizationException();
        $number = $this->getNextEmployeeIdLastNumber();
        $entity->setUsername($number);
        $entity->generateRandomPassword();
        return $this->insert($entity);
    }

    /**
     * @return int
     */
    public function getLastCountThisYear(): int
    {
        $currentYear = date("Y"); // Get the current year
        $dateValue = $currentYear . "-01-01"; // Concatenate the year with the desired month and day
        $params = ['created_at >=' => $dateValue];
        return $this->builder()->where($params)->countAllResults();
    }

    /**
     * @return int
     */
    public function getNextEmployeeIdLastNumber():int {
        return $this->getLastCountThisYear() +1;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array|ResultInterface|false|string
     */
    public function findAll(int $limit = 0, int $offset = 0)
    {
        if (!auth()->user()->can('users.read')) throw new AuthorizationException();
        $db = Database::connect();
        $builder = $db->table('users');
        $query = $builder->select('users.*');
        $query = $query->where('users.deleted_at', null);
        $isSuperAdmin = auth()->user()->inGroup('superadmin');
        if (!$isSuperAdmin) {
            $query = $query->where("auth_groups_users.group IS null OR auth_groups_users.group != 'superadmin' ");
        }
        $query = $query->join('auth_groups_users', "auth_groups_users.user_id = users.id", "left")->get($limit, $offset);
        $data = [];
        foreach ($query->getResult(UserEntity::class) as $row) {
            array_push($data, $row);
        }
        return $data;
    }


    /**
     * @param string $employeeId
     * @return array|object|null
     */
    public function findOne(string $employeeId):UserEntity
    {
        if (!auth()->user()->can('users.read')) throw new AuthorizationException();
        $db = Database::connect();
        $builder = $db->table('users');
        $query = $builder->select('users.*');
        $query = $query->where('users.deleted_at', null);
        $query = $query->where('users.username', $employeeId);
        $isSuperAdmin = auth()->user()->inGroup('superadmin');
        if (!$isSuperAdmin) {
            $query = $query->where("auth_groups_users.group IS null OR auth_groups_users.group != 'superadmin' ");
        }
        $query = $query->join('auth_groups_users', "auth_groups_users.user_id = users.id", "left")->get();
        return ($query->getFirstRow(UserEntity::class));
    }

    /**
     * @param string $employeeId
     * @return void
     */
    public function deleteByEmployeeId(string $employeeId)
    {

        if (!auth()->user()->can('users.delete')) throw new AuthorizationException();
        $this->where(['employee_id' => $employeeId])->delete();
    }

    public function updateByEmployeeId(string $employeeId, array $data){
        if (!auth()->user()->can('users.edit')) throw new AuthorizationException();
        $user = $this->findOne($employeeId);
        $user->firstname = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->setPassword($data['confirmation_code']);
        $user->setEmail($data['email']);
        $this->save($user);
    }
}
