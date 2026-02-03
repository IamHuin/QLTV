<?php

namespace App\Repository\Eloquent;

use App\Models\RolePermission;
use App\Repository\Contract\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
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
