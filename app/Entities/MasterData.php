<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use DateTime;

/**
 * @property int|string|null $id
 * @property string|null $name
 * @property int|null $weight
 * @property int|string|null $dimension
 */
class MasterData extends Entity
{
    private ?string $type;

    protected $datamap = [
        'type' => 'masterdata_type',
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'id' => '?integer',
        'active' => 'int_bool',
    ];

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->attributes['masterdata_type'];
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->attributes['masterdata_type'] = $type;
    }


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
     * @param $dateString
     * @return string
     */
    function translateDateFormat($dateString): string
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
        return $date->format('d F Y');
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->translateDateFormat($this->attributes['created_at']);
    }

}
