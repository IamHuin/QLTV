<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    protected $table = "profiles";
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'age',
        'phone',
    ];
}
