<?php

namespace App\Entities;


use App\Models\UserModel;
use CodeIgniter\Entity\Entity;

class Shift extends Entity
{

    protected array $operators;

    private array $constant_shift_data = [
        [
            "name" => "Shift A",
            "start_time" => "10:00",
            "end_time" => "15:00",
        ],
        [
            "name" => "Shift B",
            "start_time" => "15:00",
            "end_time" => "24:00",
        ],
    ];

    public function getShiftData(): array
    {
        if (!array_key_exists($this->id, $this->constant_shift_data)) {
            return $this->constant_shift_data[0];
        }
        return $this->constant_shift_data[$this->id];
    }


    /**
     * @return UserModel[]
     */
    public function getOperators(): array
    {
        return $this->operators;
    }

    /**
     * @param UserModel[] $operators
     */
    public function setOperators(array $operators): void
    {
        $this->operators = $operators;
    }

}