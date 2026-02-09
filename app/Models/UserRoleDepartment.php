<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoleDepartment extends Model
{
    /** @use HasFactory<\Database\Factories\UserRoleDepartmentFactory> */
    use HasFactory;

    protected $table = 'user_role_department';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'role_id',
        'department_id',
        'status'
    ];
}
