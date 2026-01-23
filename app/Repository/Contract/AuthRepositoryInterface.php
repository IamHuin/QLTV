<?php

namespace App\Repository\Contract;

interface AuthRepositoryInterface
{
    public function register($data);
    public function login($username);
    public function rolePermission(array $data);
}
