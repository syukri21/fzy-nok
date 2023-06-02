<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class MasterData extends Entity
{

    protected $datamap = [
        'type' => 'masterdata_type',
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'id' => '?integer',
        'active' => 'int_bool',
    ];

    private string $type;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->attributes['masterdata_type'];
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->attributes['masterdata_type'] = $type;
    }


}
