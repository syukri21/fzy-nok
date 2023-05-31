<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Shield\Authorization\AuthorizationException;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

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
        $entity->setUsername( $number);
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
     * @return array
     */
    public function findAll(int $limit = 0, int $offset = 0): array
    {
        if (!auth()->user()->can('users.read')) throw new AuthorizationException();
        return parent::findAll($limit, $offset);
    }

}
