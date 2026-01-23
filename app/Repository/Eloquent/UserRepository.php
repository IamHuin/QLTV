<?php

namespace App\Reposiroty\Eloquent;

use App\Models\Member;
use App\Models\Profile;
use App\Models\User;
use App\Reposiroty\Contract\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function getUserByUsername(string $username)
    {
        // TODO: Implement getUserByUsername() method.
        $user = User::where('username', $username)->first();
        if (isset($user)) {
            return $user;
        }
        return null;
    }

    public function updateUserByUsername(array $data, $id)
    {
        // TODO: Implement updateUserByUsername() method.
        $update = User::where('id', $id)->first();
        if (isset($update)) {
            $update->update($data);
            return $update;
        }
        return null;
    }

    public function deleteUser($id)
    {
        // TODO: Implement deleteUser() method.
        $delete = User::find($id)->delete();
        return $delete;
    }

    public function showAllUsers()
    {
        // TODO: Implement showAllUsers() method.
        $users = User::where([
            ['role_id', 2],
        ])->paginate(20);
        return $users;
    }

    public function showUser($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function getAllEmail()
    {
        // TODO: Implement getAllEmail() method.
        $data = User::paginate(4);
        return $data;
    }
}
