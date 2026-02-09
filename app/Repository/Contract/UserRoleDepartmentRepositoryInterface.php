<?php

namespace App\Repository\Contract;

interface UserRoleDepartmentRepositoryInterface
{
    public function createUserRoleDepartment($request);

    public function showUserRoleDepartment($data);

    public function updateUserRoleDepartment($data);

    public function destroyUserRoleDepartment($data);

}
