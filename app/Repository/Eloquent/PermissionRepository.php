<?php

namespace App\Repository\Eloquent;

use App\Models\Permission;
use App\Repository\Contract\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{

    public function createPermission(array $data)
    {
        // TODO: Implement createPermission() method.
        $exist = Permission::where('name', $data['name'])->exists();
        if ($exist) {
            return null;
        }
        return Permission::create($data);
    }

    public function showPermission()
    {
        // TODO: Implement showPermission() method.
        return Permission::all();
    }

    public function updatePermission($permission, array $data)
    {
        // TODO: Implement updatePermission() method.
        $find = Permission::find($permission);
        if (isset($find)) {
            $find->update($data);
        }
        return $find;
    }

    public function deletePermission($permission)
    {
        // TODO: Implement deletePermission() method.
        $exist = Permission::where('id', $permission)->exists();
        if (!$exist) {
            return null;
        }
        return Permission::find($permission)->delete();
    }
}
