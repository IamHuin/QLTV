<?php

namespace App\Repository\Eloquent;

use App\Models\Permission;
use App\Models\Profile;
use App\Models\RolePermission;
use App\Models\User;
use App\Repository\Contract\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{

    public function register($data)
    {
        // TODO: Implement register() method.
        $exists = User::where('username', $data['username'])->exists();
        if (!$exists) {
            $register = User::create($data);
            Profile::create([
                'user_id' => $register->id,
                'name' => '',
                'age' => '',
                'phone' => '',
            ]);
            return $register;
        }
        return null;
    }

    public function login($username)
    {
        // TODO: Implement login() method.
        $user = User::where('username', $username)->first();
        if (isset($user)) {
            return $user;
        }
        return false;
    }

    public function rolePermission(array $data)
    {
        $role_id = $data['role_id'];
        $list_permission = $data['permission_id'];
        RolePermission::where('role_id', $role_id)->delete();
        foreach ($list_permission as $permission) {
            RolePermission::create([
                'role_id' => $role_id,
                'permission_id' => $permission
            ]);
        }
        return true;
    }
}
