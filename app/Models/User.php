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
        'delete_at'
    ];

    public static function roleResole($role_id)
    {
        $role = [
            1 => 'admin',
            2 => 'user',
            3 => 'pm',
        ];
        return $role[$role_id] ?? 'user';
    }

    public function role()
    {
        $user_id = $this->id;
        return UserRoleDepartment::where('user_id', $user_id)->first()->role_id;
    }

    public function hasRole($user, $role)
    {
        $role_id = Role::where('name', $role)->first()->id;
        $user_id = $user->id;
        return UserRoleDepartment::where([
            'user_id' => $user_id,
            'role_id' => $role_id
        ])->exists();
    }

    public function hasPermission($permission)
    {
        $check = Permission::where('name', $permission)->first();
        if (!$check) {
            return false;
        }
        $role_id = $this->role();
        return RolePermission::where('role_id', $role_id)
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
