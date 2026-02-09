<?php

namespace App\Repository\Contract;

interface UserRepositoryInterface
{
    public function searchUser($data, $search);

    public function showAllUsers($data);

    public function updateUserByUsername(array $data, $id);

    public function deleteUser($id);

    public function showUser($id);

    public function getAllEmail();
}
