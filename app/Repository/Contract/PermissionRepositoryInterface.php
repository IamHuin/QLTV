<?php

namespace App\Repository\Contract;

interface PermissionRepositoryInterface
{
    public function createPermission(array $data);
    public function showPermission();

    public function updatePermission($permission, array $data);
    public function deletePermission($permission);
}
