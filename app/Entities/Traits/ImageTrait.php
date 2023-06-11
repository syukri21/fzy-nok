<?php

namespace App\Entities\Traits;

trait ImageTrait
{
    public function getImageBase64(string $nameAttr = 'image'): string
    {
        helper('image_not_found');
        $imagePath = $this->attributes[$nameAttr] ?? '404.jpg';
        $imagePath = WRITEPATH . 'uploads/' . $imagePath;
        if (!empty($this->attributes[$nameAttr])) {
            $extension = pathinfo($this->attributes[$nameAttr], PATHINFO_EXTENSION);
        }

        if (!file_exists($imagePath)) {
            return NotFoundImage;
        }

        $imageData = file_get_contents($imagePath);
        if ($imageData === false) {
            return NotFoundImage;
        }
        return "data:image/$extension;base64," . base64_encode($imageData);
    }

}