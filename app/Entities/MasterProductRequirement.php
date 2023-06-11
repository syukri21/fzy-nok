<?php

namespace App\Entities;

use App\Entities\Traits\CurrencyTrait;
use CodeIgniter\Entity\Entity;

/**
 * @property int|string|null $id
 * @property int|null $masterdata_id
 * @property int|null $masterproduct_id
 * @property int|null $masterdata_qty
 */
class MasterProductRequirement extends Entity
{
    use CurrencyTrait;

    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];
}
