<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

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
            'last_name'
        ];
    }
}
