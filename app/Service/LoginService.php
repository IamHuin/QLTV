<?php

namespace App\Service;

use App\Repository\Contract\LoginRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LoginService
{
    protected $loginRepo;

    public function __construct(LoginRepositoryInterface $loginRepo)
    {
        $this->loginRepo = $loginRepo;
    }

    public function loginUser($data)
    {
        $user = $this->loginRepo->login($data);
        if (empty($user) || !$token = JWTAuth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            return null;
        }
        return ['data' => $user, 'token' => $token];
    }
}
