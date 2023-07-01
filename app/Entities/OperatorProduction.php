<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class OperatorProduction extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public array $shifts = [];

    /**
     * @param array $shifts
     * @return OperatorProduction
     */
    public function setShifts(array $shifts): OperatorProduction
    {
        $this->shifts = $shifts;
        return $this;
    }

}
