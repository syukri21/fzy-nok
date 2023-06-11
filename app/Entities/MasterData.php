<?php

namespace App\Entities;

use App\Entities\Traits\CurrencyTrait;
use App\Entities\Traits\ImageTrait;
use CodeIgniter\Entity\Entity;
use DateTime;

/**
 * @property int|string|null $id
 * @property string|null $name
 * @property int|null $weight
 * @property int|string|null $dimension
 */
class MasterData extends Entity
{
    use CurrencyTrait;
    use ImageTrait;
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

    /**
     * @param $dateString
     * @return string
     */
    function translateDateFormat($dateString): string
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
        return $date->format('d F Y');
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->translateDateFormat($this->attributes['created_at']);
    }

}
