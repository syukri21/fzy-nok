<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProductionPlan extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'order_date', 'due_date'];
    protected $casts = [
        'id' => 'int',
        'quantity' => 'int',
        'order_date' => 'datetime',
        'due_date' => 'datetime',
        'status' => 'string',
    ];

}
