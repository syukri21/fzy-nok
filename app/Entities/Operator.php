<?php

namespace App\Entities;

class Operator extends UserEntity
{

    /**
     * @param string|null $first_name
     * @return Operator
     */
    public function setFirstName(?string $first_name): Operator
    {
        $this->attributes['first_name'] = $first_name;
        return $this;
    }

    /**
     * @param string $last_name
     * @return Operator
     */
    public function setLastName($last_name): Operator
    {
        $this->attributes['last_name'] = $last_name;
        return $this;
    }

    /**
     * @param string $employee_id
     * @return Operator
     */
    public function setEmployeeId(string $employee_id): Operator
    {
        $this->attributes['employee_id'] = $employee_id;
        return $this;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): Operator
    {
        $this->attributes['id'] = $id;
        return $this;
    }

}