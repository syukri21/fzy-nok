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
        'evidence' => 'string',
        'checked_by' => 'string',
        'reported_by' => 'string'
    ];

    public function evidence(int $index)
    {
        $evidence_json = $this->evidences();
        return $evidence_json[$index];
    }

    public function evidences()
    {
        return json_decode($this->attributes['evidence']);
    }


}
