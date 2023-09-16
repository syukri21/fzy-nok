<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProductionResult extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'production_date'];
    protected $casts = [
        'id' => 'int',
        'production_plans_id' => 'int',
        'quantity_produced' => 'int',
        'quantity_rejected' => 'time',
        'production_date' => 'datetime',
    ];
}
