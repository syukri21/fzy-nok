<?php

namespace App\Entities;

use App\Entities\Traits\CurrencyTrait;
use App\Entities\Traits\ImageTrait;
use CodeIgniter\Entity\Entity;

/**
 * @property int|string|null $id
 * @property string|null $name
 * @property string|null $code
 * @property int|null $price
 * @property string|null $dueDate
 * @property string|null $description
 * @property array|null $requirements
 * @property string|null $image
 */
class MasterProduct extends Entity
{
    use ImageTrait;
    use CurrencyTrait;

    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'due_date'];
    protected $casts = [];
}
