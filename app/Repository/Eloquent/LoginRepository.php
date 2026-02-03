<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Contract\LoginRepositoryInterface;

class LoginRepository implements LoginRepositoryInterface
{
    public function login($data)
    {
        // TODO: Implement login() method.
        $user = User::where('username', $data['username'])->first();
        if (isset($user) && !empty($user->email_verified_at)) {
            return $user;
        }
        return null;
    }
}
