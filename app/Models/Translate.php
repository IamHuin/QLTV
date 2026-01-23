<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    protected $table = 'translates';
    protected $fillable = [
        'post_id',
        'lang',
        'title',
        'content',
    ];
}
