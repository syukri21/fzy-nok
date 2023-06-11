<?php

namespace App\Models;

use App\Entities\MasterData;
use CodeIgniter\Database\BaseResult;
use CodeIgniter\Shield\Authorization\AuthorizationException;
use ReflectionException;

class MasterDataModel extends BaseModel
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
        return parent::delete(["masterdata_id" => $id], $purge);
    }

    /**
     * @param $id
     * @return array|object
     */
    public function findOne($id)
    {
        $this->validateAuthorization('read');
        return $this->where("id", $id)->first();
    }

    public function update($id = null, $data = null): bool
    {
        $this->validateAuthorization('update');
        $masterdata = new MasterData();
        $masterdata->fill($data);
        $masterdata->setType($data['type']);
        return parent::update($id, $masterdata);
    }

    /**
     * @param string $action
     * @return void
     */
    public function validateAuthorization(string $action)
    {
        if (!auth()->user()->can('masterdatas.' . $action)) throw new AuthorizationException();
    }

    /**
     * @return string[]
     */
    public function getAllowedFields(): array
    {
        return $this->allowedFields;
    }


    /**
     * @param int $limit
     * @param int $offset
     * @param string $type
     * @return array
     */
    public function findAll(int $limit = 0, int $offset = 0, string $type = 'ALL'): array
    {
        $masterDataType = $this->transformType($type);
        $query = $this->builder();
        if ($masterDataType != "ALL") {
            $query = $query->where(['masterdata_type' => $masterDataType]);
        }
        $query = $query->orderBy('id', 'DESC')->get($limit, $offset);
        return $query->getResult(MasterData::class);
    }

    /**
     * Fetches all options value
     * @param string $type
     * @return false|string
     */
    public function findAllOptions(string $type = 'ALL')
    {
        $masterDataType = $this->transformType($type);
        $query = $this->builder()->select(['id', 'name', 'masterdata_type']);
        if ($masterDataType != "ALL") {
            $query = $query->where(['masterdata_type' => $masterDataType]);
        }
        $query = $query->orderBy('id', 'DESC')->get();
        return json_encode($query->getResult());
    }


    /**
     * @param string $type
     * @return string
     */
    private function transformType(string $type = 'ALL'): string
    {
        if ($type == 'ALL') return $type;
        if (!array_key_exists($type, MasterDataType)) {
            $type = 'ALL';
        }
        return $type;
    }

}
