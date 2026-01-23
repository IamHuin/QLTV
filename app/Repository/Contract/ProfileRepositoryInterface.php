<?php

namespace App\Repository\Contract;

interface ProfileRepositoryInterface
{
    public function showProfile($id);
    public function updateProfile($id, array $data);

}
