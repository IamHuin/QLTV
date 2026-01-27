<?php

namespace App\Repository\Contract;

interface PermissionRepositoryInterface
{
    public function createPermission(array $data);

    public function showPermission();

    public function updatePermission($id, array $data);

    public function deletePermission($id);
}
