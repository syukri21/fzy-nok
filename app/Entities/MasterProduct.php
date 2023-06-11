<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int|string|null $id
 * @property string|null $name
 * @property string|null $code
 * @property int|null $price
 * @property string|null $dueDate
 * @property string|null $description
 * @property array|null $requirements
 * @property string|null $image
 */
class MasterProduct extends Entity
{
    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'due_date'];
    protected $casts = [];

    /**
     * @return string
     */
    public function getImageBase64(): string
    {
        helper('image_not_found');
        $imagePath = $this->image ?? '404.jpg';
        $imagePath = WRITEPATH . 'uploads/' . $imagePath;
        $extension = pathinfo($this->image, PATHINFO_EXTENSION);

        if (!file_exists($imagePath)) {
            return NotFoundImage;
        }

        $imageData = file_get_contents($imagePath);
        if ($imageData === false) {
            return NotFoundImage;
        }


        return "data:image/$extension;base64," . base64_encode($imageData);
    }

    /**
     * @return string
     */
    public function getPriceRupiah(): string
    {
        $formattedAmount = number_format($this->price, 2, ',', '.');
        return 'Rp ' . $formattedAmount;
    }
}
