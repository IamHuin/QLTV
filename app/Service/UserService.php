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

    public function showAllUser($data)
    {
        $dataShow = $this->userRepo->showAllUsers($data);
        return $dataShow;
    }

    public function searchUser($data, $search)
    {
        $user = $this->userRepo->searchUser($data, $search);
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
