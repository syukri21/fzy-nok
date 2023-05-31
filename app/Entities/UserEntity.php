<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User;

class UserEntity extends User
{

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->attributes['first_name'];
    }

    /**
     * @param string|null $first_name
     * @return UserEntity
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
     * @return UserEntity
     */
    public function setLastName(?string $last_name): UserEntity
    {
        $this->attributes['last_name'] = $last_name;
        return $this;
    }

    public function setUsername(int $number): UserEntity
    {
        $username = $this->generateUserName($number);
        $this->attributes['username'] = $username;
        $this->attributes['employee_id'] = $username;
        return $this;
    }

    /**
     * @param int $length
     * @return UserEntity
     */
    function generateRandomPassword(int $length = 8): UserEntity
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        $charCount = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $randomChar = $characters[rand(0, $charCount - 1)];
            $password .= $randomChar;
        }
        $this->attributes['confirmation_code'] = $password;
        return $this->setPassword($password);
    }

    /**
     * @param $number
     * @return string
     */
    private function generateUserName($number): string
    {
        $last = str_pad($number, 5, "0", STR_PAD_LEFT);
        return 'NOK'.date("Y").$last;
    }

    /**
     * @return void
     */
    public function activate(): void
    {
        $users = auth()->getProvider();
        $users->update($this->id, ['active' => 1, 'confirmation_code' => null]);
    }

}
