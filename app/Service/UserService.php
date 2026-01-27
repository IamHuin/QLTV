<?php

namespace App\Service;

use App\Repository\Contract\UserRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

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
        $user = JWTAuth::user();
        if ($user['role_id'] == 1 || ($user['role_id'] == 2 && $user['id'] == $id)) {
            $update = $this->userRepo->updateUserByUsername([
                'password' => bcrypt($data['password']),
            ], $id);
            return $update;
        }
        return null;
    }

    public function deleteUser($id)
    {
        $delete = $this->userRepo->deleteUser($id);
        return $delete;
    }

}
