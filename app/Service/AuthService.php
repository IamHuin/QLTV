<?php

namespace App\Service;

use App\Repository\Contract\AuthRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

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

    public function refreshToken()
    {
        $token = JWTAuth::getToken();
        $new_token = JWTAuth::setToken($token)->refresh();
        return $new_token;
    }
}
