<?php

namespace App\Service;

use App\Reposiroty\Contract\AuthRepositoryInterface;
use App\Reposiroty\Eloquent\AuthRepository;

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
