<?php

namespace App\Models;

use App\Entities\MasterProduct;
use CodeIgniter\Database\BaseResult;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Shield\Authorization\AuthorizationException;

class MasterProductModel extends BaseModel
{
    protected $DBGroup = 'default';

    protected $table = 'master_products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = MasterProduct::class;
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'name',
        'code',
        'price',
        'due_date',
        'description',
        'image',
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $validationRules = [
        'name' => 'required|alpha_numeric|min_length[3]',
        'code' => 'required|alpha_numeric|min_length[3]',
        'price' => 'required|greater_than[0]',
        'due_date' => 'required',
        'description' => 'alpha_numeric_space',
    ];
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
    protected ?UploadedFile $tempUpload = null;


    /**
     * @param null $data
     * @param bool $returnID
     * @return BaseResult|false|int|object|string
     * @throws \ReflectionException
     */
    public function insert($data = null, bool $returnID = true)
    {
        $this->validateAuthorization('create');
        $masterProduct = new MasterProduct();
        $masterProduct->fill($data);
        return parent::insert($masterProduct, $returnID);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array|null $find
     * @return array
     */
    public function findAll(int $limit = 0, int $offset = 0, ?array $find = null): array
    {
        $this->validateAuthorization('read');
        $query = $this->builder()->where('deleted_at', null);
        if (!is_null($find)) $query = $query->where($find);
        $query = $query->orderBy('id', 'DESC')->get($limit, $offset);
        return $query->getResult(MasterProduct::class);
    }

    /**
     * @param string $id
     * @return MasterProduct|array|object
     */
    public function findOne(string $id)
    {
        $this->validateAuthorization('read');
        return $this->where("id", $id)->asObject(MasterProduct::class)->first();
    }

    /**
     * @param $id
     * @param bool $purge
     * @return bool|BaseResult
     */
    public function delete($id = null, bool $purge = false)
    {
        $this->validateAuthorization("delete");
        return parent::delete(["id" => $id], $purge);
    }

    /**
     * Updates a single record of data
     * @param $id
     * @param $data
     * @return bool
     * @throws \ReflectionException
     */
    public function update($id = null, $data = null): bool
    {
        $this->validateAuthorization('update');
        $masterProduct = new MasterProduct();
        $masterProduct->fill($data);
        return parent::update($id, $masterProduct);
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
