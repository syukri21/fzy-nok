<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int|string|null $id
 * @property string|null $name
 * @property int|null $weight
 * @property int|string|null $dimension
 */
class MasterData extends Entity
{
    private ?string $type;

    protected $datamap = [
        'type' => 'masterdata_type',
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'id' => '?integer',
        'active' => 'int_bool',
    ];


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
