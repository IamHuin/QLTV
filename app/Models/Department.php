<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory, softDeletes;

    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'company_id',
        'delete_at'
    ];
}
