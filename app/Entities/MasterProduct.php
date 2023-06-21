<?php

namespace App\Entities;

use App\Entities\Traits\CurrencyTrait;
use App\Entities\Traits\ImageTrait;
use App\Models\MasterProductRequirementModel;
use CodeIgniter\Entity\Entity;

/**
 * @property int|string|null $id
 * @property string|null $name
 * @property string|null $code
 * @property int|null $price
 * @property string|null $dueDate
 * @property string|null $description
 * @property array<MasterProductRequirement::class>|null $requirements
 * @property string|null $image
 */
class MasterProduct extends Entity
{
    use ImageTrait;
    use CurrencyTrait;

    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'due_date'];
    protected $casts = [];

    protected $requirements = [];

    /**
     * @return array
     */
    public function getRequirements(): array
    {
        return $this->requirements;
    }

    /**
     * @param array $requirements
     */
    public function setRequirements(array $requirements): void
    {
        $this->requirements = $requirements;
    }


    public function getRequirementsImageBase64(): array
    {
        $bas64images = [];
        foreach ($this->requirements as $item) {
            $bas64images[] = $this->getImageBase64FromPath($item->image);
        }
        return $bas64images;
    }

}
