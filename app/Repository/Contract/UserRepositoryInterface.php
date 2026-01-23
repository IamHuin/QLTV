<?php

namespace App\Repository\Contract;

interface UserRepositoryInterface
{
    public function getUserByUsername(string $username);

    public function showAllUsers();

    public function updateUserByUsername(array $data, $id);

    public function deleteUser($id);

    public function showUser($id);

    public function getAllEmail();
}
