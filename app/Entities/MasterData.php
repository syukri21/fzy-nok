<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class MasterData extends Entity
{

    protected $datamap = [
        'type' => 'masterdata_type',
        'id' => 'masterdata_id'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'id' => '?integer',
        'active' => 'int_bool',
    ];

}
