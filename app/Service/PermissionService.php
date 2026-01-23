<?php

namespace App\Service;

use App\Reposiroty\Contract\PermissionRepositoryInterface;

class PermissionService
{
    protected $perRepo;

    public function __construct(PermissionRepositoryInterface $perRepo)
    {
        $this->perRepo = $perRepo;
    }

    public function showPermission()
    {
        return $this->perRepo->showPermission();
    }

    public function updatePermission($permission, $data)
    {
        return $this->perRepo->updatePermission($permission,[
            'name' => $data['name'],
        ]);
    }

    public function deletePermission($permission)
    {
        return $this->perRepo->deletePermission($permission);
    }

    public function createPermission($data)
    {
        return $this->perRepo->createPermission($data);
    }
}
