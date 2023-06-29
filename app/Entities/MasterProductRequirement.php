<?php

namespace App\Entities;

use App\Entities\Traits\CurrencyTrait;
use CodeIgniter\Entity\Entity;

/**
 * @property int|string|null $id
 * @property string|null $production_ticket
 * @property int|null $ppic_id
 * @property int|null $manager_id
 */
class MasterProductRequirement extends Entity
{
    use CurrencyTrait;

    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];
}
