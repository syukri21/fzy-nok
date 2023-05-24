<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User;

class UserEntity extends User
{
    private ?string $first_name = null;
    private ?string $last_name = null;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->attributes['first_name'];
    }

    /**
     * @param string|null $first_name
     */
    public function setFirstName(?string $first_name): UserEntity
    {
        $this->attributes['first_name'] = $first_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->attributes['last_name'];
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): UserEntity
    {
        $this->attributes['last_name'] = $last_name;
        return $this;
    }
}
