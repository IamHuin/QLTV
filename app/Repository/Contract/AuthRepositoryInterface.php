<?php

namespace App\Repository\Contract;

interface AuthRepositoryInterface
{
    public function rolePermission(array $data);
}
