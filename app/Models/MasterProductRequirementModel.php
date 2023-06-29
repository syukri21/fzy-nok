<?php

namespace App\Models;

use App\Entities\MasterProductRequirement;
use CodeIgniter\Shield\Authorization\AuthorizationException;
use CodeIgniter\Shield\Exceptions\ValidationException;

class MasterProductRequirementModel extends BaseModel
{
    protected $DBGroup = 'default';
    protected $table = 'agg_masterdata_masterproduct';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = MasterProductRequirement::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'masterdata_id',
        'masterdata_qty',
        'masterproduct_id'
    ];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * @throws \ReflectionException
     */
    public function createBatch(int $productId, ?array $set = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false)
    {
        if (is_null($set)) return true;
        if (count($set) == 0) return true;
        $dataSet = [];
        foreach ($set as $x => $item) {
            $newData = new MasterProductRequirement();
            $newData->masterdata_id = (int)$item['masterdata_id'];
            $newData->masterproduct_id = $productId;
            $newData->masterdata_qty = $item['quantity'];
            $dataSet[] = $newData;
        }
        return $this->insertBatch($dataSet, $escape, $batchSize, $testing);
    }

    public function findByMasterProductIds(array $masterProductIds): array
    {
        $result = $this->select('masterdata_id, masterdata_qty, masterproduct_id, masterdatas.id, masterdatas.name, masterdatas.masterdata_type, masterdatas.image')
            ->join('masterdatas', 'masterdatas.id = agg_masterdata_masterproduct.masterdata_id')
            ->whereIn('masterproduct_id', $masterProductIds)
            ->findAll();

        $requirements = [];
        foreach ($result as $row) {
            $requirements[$row->masterproduct_id][] = $row;
        }

        return $requirements;
    }

    public function findByMasterProductId(string $masterProductId): array
    {
        return $this->select('agg_masterdata_masterproduct.id, masterdata_id, masterdata_qty, masterproduct_id, masterdatas.masterdata_type, masterdatas.name,  masterdatas.image')
            ->join('masterdatas', 'masterdatas.id = agg_masterdata_masterproduct.masterdata_id')
            ->where('masterproduct_id', $masterProductId)
            ->asArray()->findAll();
    }


    public function delete($id = null, bool $purge = false)
    {
        if (is_null($id)) throw new ValidationException();
        $this->validateAuthorization("delete");
        return parent::delete($id, $purge);
    }

    public function insert($data = null, bool $returnID = true)
    {
        $this->validateAuthorization("add");
        if (is_null($data)) throw new ValidationException();
        $masterProductRequirement = new MasterProductRequirement();
        $masterProductRequirement->masterdata_id = $data->masterdata_id;
        $masterProductRequirement->masterdata_qty = $data->qty;
        $masterProductRequirement->masterproduct_id = $data->masterproduct_id;
        return parent::insert($masterProductRequirement, $returnID);
    }

    /**
     * @param string $action
     * @return void
     */
    public function validateAuthorization(string $action)
    {
        if (!auth()->user()->can('bom.' . $action)) throw new AuthorizationException();
    }

}
