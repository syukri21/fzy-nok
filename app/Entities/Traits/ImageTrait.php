<?php

namespace App\Entities\Traits;

trait ImageTrait
{
    public function getImageBase64(string $nameAttr = 'image'): string
    {
        helper('image_not_found');
        $imagePath = $this->attributes[$nameAttr] ?? '404.jpg';
        return $this->getBase64($imagePath, $nameAttr);
    }


    public function getImageBase64FromPath(string $path = '404.jpg'): string
    {
        helper('image_not_found');
        return $this->getBase64($path,);
    }

    /**
     * @param $imagePath
     * @param string $nameAttr
     * @return string
     */
    public function getBase64($imagePath): string
    {
        $imagePath = WRITEPATH . 'uploads/' . $imagePath;
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

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