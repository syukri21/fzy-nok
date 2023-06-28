<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class MaterialListEditCell extends Cell
{
    public string $options = "[]";
    public array $materials = [];
    public ?int $masterProductId = null;
}
