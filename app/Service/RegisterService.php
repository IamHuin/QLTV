<?php

namespace App\Service;

use App\Repository\Contract\AuthRepositoryInterface;

class RegisterService
{
    protected $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function registerUser($data)
    {
        $register = $this->authRepo->register([
            'role_id' => 2,
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'email' => $data['email'],
        ]);
        return $register;
    }
}
