<?php

namespace App\Models;

use App\Entities\MasterData;
use CodeIgniter\Model;
use CodeIgniter\Shield\Authorization\AuthorizationException;
use ReflectionException;

class MasterDataModel extends Model
{
    protected $returnType    = MasterData::class;
    protected $DBGroup          = 'default';
    protected $table            = 'masterdatas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'id',
        'type',
        'name',
        'weight',
        'dimension',
        'image',
        'masterdata_type'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    /**
     * @param array $data
     * @return bool
     * @throws ReflectionException
     */
    public function create(array $data): bool
    {
        if (!auth()->user()->can('masterdatas.create')) throw new AuthorizationException();
        $masterdata = new MasterData();
        $masterdata->fill($data);
        $masterdata->setType($data['type']);
        return $this->insert($masterdata);
    }

}
