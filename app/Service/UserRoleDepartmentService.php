<?php

namespace App\Service;

use App\Repository\Contract\UserRoleDepartmentRepositoryInterface;

class UserRoleDepartmentService
{
    protected $urdRepo;

    public function __construct(UserRoleDepartmentRepositoryInterface $urdRepo)
    {
        $this->urdRepo = $urdRepo;
    }

    public function createUserRoleDepartment($request)
    {
        return $this->urdRepo->createUserRoleDepartment($request);
    }

    public function showURD($data)
    {
        return $this->urdRepo->showUserRoleDepartment($data);
    }

    public function destroyURD($data)
    {
        return $this->urdRepo->destroyUserRoleDepartment($data);
    }
}
