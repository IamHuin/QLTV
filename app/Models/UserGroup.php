<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    /** @use HasFactory<\Database\Factories\UserGroupFactory> */
    use HasFactory;

    protected $table = 'user_group';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'group_id',
    ];
}
