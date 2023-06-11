<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{

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

}
