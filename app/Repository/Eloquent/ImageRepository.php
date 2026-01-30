<?php

namespace App\Repository\Eloquent;

use App\Models\Image;
use App\Repository\Contract\ImageRepositoryInterface;

class ImageRepository implements ImageRepositoryInterface
{
    public function createImage($data)
    {
        // TODO: Implement createImage() method.
        foreach ($data['images'] as $image) {
            Image::create([
                'post_id' => $data['post_id'],
                'image' => $image,
            ]);
        }
        return true;
    }
}
