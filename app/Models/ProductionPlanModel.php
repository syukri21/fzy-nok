<?php

namespace App\Models;

use App\Entities\ProductionPlan;
use CodeIgniter\Shield\Authorization\AuthorizationException;
use Faker\Factory;

class ProductionPlanModel extends BaseModel
{
    protected $DBGroup = 'default';
    protected $table = 'production_plans';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = ProductionPlan::class;
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'production_ticket',
        'quantity',
        'order_date',
        'due_date',
        'done_date',
        'ppic_id',
        'manager_id',
        'master_products_id',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];


    /**
     * @param int $perPage
     * @return array
     */
    public function  findAllTodo(int $perPage = 20): array
    {
        $this->validateAuthorization("read");
        return $this->todo()->paginate($perPage, "todo");
    }

    /**
     * @param int $perPage
     * @return array
     */
    public function findAllDone(int $perPage = 20): array
    {
        $this->validateAuthorization("read");
        return $this->done()->paginate($perPage, "done");
    }

    /**
     * @param int $perPage
     * @return array
     */
    public function findAllOnProgress(int $perPage = 20): array
    {
        $this->validateAuthorization("read");
        return $this->onProgress()->paginate($perPage, "progress");
    }

    /**
     * @param $id
     * @return array|ProductionPlan|null
     */
    public function find($id = null)
    {
        $this->validateAuthorization("read");
        return parent::find($id);
    }


    public function todo(): ProductionPlanModel
    {

        $base = $this->findAllBase();
        $base->where("production_plans.status", TODO);
        return $this;
    }

    public function done(): ProductionPlanModel
    {
        $base = $this->findAllBase();
        $base->where("production_plans.status", DONE);
        return $this;
    }

    public function onProgress(): ProductionPlanModel
    {
        $base = $this->findAllBase();
        $base->where("production_plans.status", ONPROGRESS);
        return $this;
    }

    public function validateAuthorization(string $action)
    {
        if (!auth()->user()->can('production_plans.' . $action)) throw new AuthorizationException();
    }

    /**
     * @param int $count
     * @return array
     */
    public function generateFakeData(int $count = 10): array
    {

        $faker = Factory::create("id_ID");
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'master_products_id' => $faker->randomElement([22, 23, 24, 25]),
                'production_ticket' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'quantity' => $faker->numberBetween(1, 100),
                'order_date' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'due_date' => $faker->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d H:i:s'),
                'done_date' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'ppic_id' => 45,
                'manager_id' => 46,
                'status' => $faker->randomElement(['TODO', 'ONPROGRESS', 'DONE']),
            ];
        }

        return $data;
    }

    /**
     * @return \CodeIgniter\Database\BaseBuilder|null
     */
    public function findAllBase(): ?\CodeIgniter\Database\BaseBuilder
    {
        return $this->builder()
            ->select("ppic.employee_id as ppic_employee_id, ppic.first_name as ppic_first_name")
            ->select("manager.employee_id as manager_employee_id, manager.first_name as manager_first_name")
            ->select("production_plans.id as id, quantity, production_ticket, ppic_id, due_date, done_date")
            ->join("users as ppic", "production_plans.ppic_id = ppic.id", "left")
            ->join("users as manager", "production_plans.manager_id = manager.id", "left");
    }

    public function isExistTicket(string $ticket): bool
    {
        $first = $this->where("production_ticket", $ticket)->first();
        return !empty($first);
    }
}
