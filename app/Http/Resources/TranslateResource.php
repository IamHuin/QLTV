<?php

namespace App\Http\Resources;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->post_id,
            'title' => $this->title,
            'content' => $this->content,
            'images' => Image::imagePath($this->post_id),
            'created_at' => date($this->created_at)
        ];
    }
}
