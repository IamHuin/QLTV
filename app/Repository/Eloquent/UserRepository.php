<?php

namespace App\Repository\Eloquent;

use App\Models\Profile;
use App\Models\User;
use App\Repository\Contract\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function searchUser($data, $search)
    {
        // TODO: Implement searchUser() method.
        $limit = $data['paginate']['limit'];
        $page = $data['paginate']['page'];
        $maxPage = $data['paginate']['maxPage'];
        if ($page > $maxPage) {
            return response()->json([
                'error' => 'maxPage',
            ], 400);
        }
        $user = User::where('username', 'like', '%' . $search . '%')->paginate($limit);
        return [
            'data' => $user,
            'paginate' => $user
        ];
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

    public function showAllUsers($data)
    {
        // TODO: Implement showAllUsers() method.
        $limit = $data['paginate']['limit'];
        $page = $data['paginate']['page'];
        $maxPage = $data['paginate']['maxPage'];

        if ($page > $maxPage) {
            return response()->json([
                'error' => 'maxPage',
            ], 400);
        }
        $user = User::where([
            ['username', '!=', 'admin'],
        ])->paginate($limit);
        return [
            'data' => $user,
            'paginate' => $user
        ];
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
