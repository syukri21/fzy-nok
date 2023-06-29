<?php

namespace App\Entities;

use App\Models\UserModel;
use CodeIgniter\Entity\Entity;

/**
 * @property int|string|null $id
 * @property int|null $masterdata_id
 * @property int|null $masterproduct_id
 * @property int|null $masterdata_qty
 */
class ProductionPlan extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'order_date', 'due_date', 'done_date'];
    protected $casts = [
        'id' => 'int',
        'quantity' => 'int',
        'order_date' => 'datetime',
        'due_date' => 'datetime',
        'status' => 'string',
    ];

    protected UserModel $PPIC;

    /**
     * @return UserModel
     */
    public function getPPIC(): UserModel
    {
        return $this->PPIC;
    }

    /**
     * @param UserModel $ppic
     */
    public function setPPIC(UserModel $ppic): void
    {
        $this->PPIC = $ppic;
    }
}
