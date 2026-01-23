<?php

namespace App\Service;

use App\Repository\Contract\AuthRepositoryInterface;
use App\Repository\Eloquent\AuthRepository;

class AuthService
{
    protected $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function rolePermission($data)
    {
        return $this->authRepo->rolePermission($data);
    }
}
