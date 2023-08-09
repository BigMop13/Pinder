<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Image;

class ImageFactory
{
    public static function create(string $imageUrl): Image
    {
        return (new Image())
            ->setImageUrl($imageUrl);
    }
}
