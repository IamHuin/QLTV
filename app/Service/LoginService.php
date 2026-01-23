<?php

namespace App\Service;

use App\Reposiroty\Contract\AuthRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LoginService
{
    protected $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function loginUser($data)
    {
        $login = $this->authRepo->login($data['username']);
        if (!$token = JWTAuth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
        return [
            'token' => $token,
            'login' => $login,
        ];
    }
}
