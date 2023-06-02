<?php

namespace App\Models;

use App\Entities\MasterData;
use CodeIgniter\Database\BaseResult;
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
        $this->validateAuthorization('create');
        $masterdata = new MasterData();
        $masterdata->fill($data);
        $masterdata->setType($data['type']);
        return $this->insert($masterdata);
    }

    /**
     * @param $id
     * @param bool $purge
     * @return bool|BaseResult
     */
    public function delete($id = null, bool $purge = false)
    {
        $this->validateAuthorization('delete');
        return parent::delete(["masterdata_id" =>$id], $purge);
    }

    /**
     * @param string $action
     * @return void
     */
    public function validateAuthorization(string $action)
    {
        if (!auth()->user()->can('masterdatas.' . $action)) throw new AuthorizationException();
    }
}
