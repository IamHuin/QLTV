<?php

namespace App\Repository\Contract;

interface RegisterRepositoryInterface
{
    public function register($data);

    public function verifyEmail($data);

}
