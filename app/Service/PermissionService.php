<?php

namespace App\Service;

use App\Repository\Contract\PermissionRepositoryInterface;

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

    public function updatePermission($id, $data)
    {
        return $this->perRepo->updatePermission($id, [
            'name' => $data['name'],
        ]);
    }

    public function deletePermission($id)
    {
        return $this->perRepo->deletePermission($id);
    }

    public function createPermission($data)
    {
        return $this->perRepo->createPermission($data);
    }
}
