<?php

namespace App\Models;

use App\Entities\MasterProduct;
use CodeIgniter\Database\BaseResult;
use CodeIgniter\Files\Exceptions\FileException;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Model;
use CodeIgniter\Shield\Authorization\AuthorizationException;

class MasterProductModel extends Model
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

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
//    protected $validationRules = [];

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
    protected ?string $tempPath = null;

    /**
     * @param $data
     * @return BaseResult|false|int|object|string
     * @throws \ReflectionException
     */
    public function create($data = null)
    {
        $this->validateAuthorization('create');
        $masterProduct = new MasterProduct();
        $masterProduct->fill($data);
        if ($this->tempPath != null) $masterProduct->image = $this->tempPath;
        return $this->insert($masterProduct);
    }


    /**
     * @return string|null
     */
    public function hasError(): ?string
    {
        if (count($this->validation->getErrors()) === 0) {
            return null;
        }
        $errors = $this->validation->getErrors();
        return $this->validation->getError(array_key_first($errors));
    }

    public
    function validateAuthorization(string $action)
    {
        if (!auth()->user()->can('bom.' . $action)) throw new AuthorizationException();
    }

    /**
     * @param UploadedFile|null $file
     * @return MasterProductModel
     */
    public
    function withUpload(?UploadedFile $file): MasterProductModel
    {
        if ($file == null) return $this;
        if ($file->getSize() == 0) return $this;
        if (!$path = $file->store('masterdata/')) {
            throw new FileException();
        }
        $this->tempPath = $path;
        return $this;
    }

}
