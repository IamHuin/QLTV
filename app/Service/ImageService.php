<?php

namespace App\Service;

use App\Models\User;
use App\Repository\Contract\ImageRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ImageService
{
    protected $imgRepo;

    public function __construct(ImageRepositoryInterface $imgRepo)
    {
        $this->imgRepo = $imgRepo;
    }

    public function createImage($request, $id)
    {
        $imgPath = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imgPath[] = $image->store('images', 'public');
            }
        }
        return $this->imgRepo->createImage([
            'post_id' => $id,
            'images' => $imgPath,
        ]);
    }
}
