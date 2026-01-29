<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory, softDeletes;

    protected $table = 'images';
    protected $primaryKey = 'id';
    protected $fillable = [
        'post_id',
        'image',
        'delete_at'
    ];

    public static function imagePath($post_id)
    {
        $imagePath = Image::where('post_id', $post_id)->get('image');
        $url = [];
        foreach ($imagePath as $path) {
            $url[] = '/storage/' . $path->image;
        }
        return $url;
    }
}
