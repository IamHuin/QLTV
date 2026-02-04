<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id';


    protected $fillable = [
        'id',
        'role_id',
        'username',
        'password',
        'email',
        'otp_code',
        'otp_expires',
        'email_verified_at',
        'delete_at'
    ];

    protected $hidden = [
        'password',
        'otp_code',
        'otp_expires',
        'email_verified_at',
    ];

    public static function roleResole($role_id)
    {
        $role = [
            1 => 'admin',
            2 => 'user',
        ];
        return $role[$role_id] ?? 'user';
    }

    public function hasPermission($permission)
    {
        $check = Permission::where('name', $permission)->first();
        if (!$check) {
            return false;
        }
        return RolePermission::where('role_id', $this->role_id)
            ->where('permission_id', $check->id)
            ->exists();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
