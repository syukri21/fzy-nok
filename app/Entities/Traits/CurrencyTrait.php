<?php

namespace App\Entities\Traits;

trait CurrencyTrait
{
    /**
     * @return string
     */
    public function getPriceRupiah(): string
    {
        $formattedAmount = "0,00";
        if (!empty($this->price)) {
            $formattedAmount = number_format($this->price, 2, ',', '.');
        }
        return 'Rp ' . $formattedAmount;
    }
}