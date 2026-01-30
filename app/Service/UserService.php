<?php

namespace App\Service;

use App\Repository\Contract\UserRepositoryInterface;

class UserService
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function showUser($id)
    {
        $data = $this->userRepo->showUser($id);
        return $data;
    }

    public function showAllUser()
    {
        $data = $this->userRepo->showAllUsers();
        return $data;
    }

    public function searchUser($username)
    {
        $user = $this->userRepo->getUserByUsername($username);
        return $user;
    }

    public function updateUser($data, $id)
    {
        return $this->userRepo->updateUserByUsername([
            'password' => bcrypt($data['password']),
        ], $id);
    }

    public function deleteUser($id)
    {
        $delete = $this->userRepo->deleteUser($id);
        return $delete;
    }

}
