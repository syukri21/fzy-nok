<?php

namespace App\Models;

use App\Entities\MasterData;
use App\Entities\MasterProductRequirement;

class MasterProductRequirementModel extends BaseModel
{
    protected $DBGroup = 'default';
    protected $table = 'agg_masterdata_masterprodcut';
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
            $newData->masterdata_id = (int)$item['id'];
            $newData->masterproduct_id = $productId;
            $newData->masterdata_qty = $item['quantity'];
            $dataSet[] = $newData;
        }
        return $this->insertBatch($dataSet, $escape, $batchSize, $testing);
    }

    public function findByMasterProductIds(array $masterProductIds): array
    {
        $result = $this->select('masterdata_id, masterdata_qty, masterproduct_id, masterdatas.id, masterdatas.name, masterdatas.image')
            ->join('masterdatas', 'masterdatas.id = agg_masterdata_masterprodcut.masterdata_id')
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
        $result = $this->select('masterdata_id, masterdata_qty, masterproduct_id, masterdatas.id, masterdatas.name, masterdatas.image')
            ->join('masterdatas', 'masterdatas.id = agg_masterdata_masterprodcut.masterdata_id')
            ->where('masterproduct_id', $masterProductId)
            ->findAll();


        $requirements = [];
        foreach ($result as $row) {
            $masterDataItem = new MasterData();
            $masterDataItem->id = $row['id'];
            $masterDataItem->name = $row['name'];
            $masterDataItem->dimension = $row['image'];
            $requirements[] = $masterDataItem;
        }

        return $requirements;
    }
}
