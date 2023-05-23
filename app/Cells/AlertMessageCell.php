<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class AlertMessageCell extends Cell
{
    //
    public $type;
    public $error;
    public $errors;

    public function getMessage()
    {
        if ($this->error !== null) {
            return $this->error;
        }


        if ($this->errors !== null && sizeof($this->errors) > 0) {
            foreach ($this->errors as $error) {
                return $error;
            }
        }

        return "";
    }


    public function isOpen(): bool
    {
        if ($this->error !== null){
            return true;
        }
        if ($this->errors !== null && sizeof($this->errors) > 0){
            return true;
        }

        return false;
    }


}
