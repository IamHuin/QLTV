<?php

namespace App\Repository\Eloquent;

use App\Models\Profile;
use App\Models\User;
use App\Repository\Contract\RegisterRepositoryInterface;

class RegisterRepository implements RegisterRepositoryInterface
{

    public function register($data)
    {
        // TODO: Implement register() method.
        $exists = User::where('username', $data['username'])->exists();
        if (!$exists) {
            $register = User::create($data);
            Profile::create([
                'user_id' => $register->id,
                'name' => '',
                'age' => '',
                'phone' => '',
            ]);
            return $register;
        }
        return null;
    }

    public function verifyEmail($data)
    {
        // TODO: Implement verifyEmail() method.
        $user = User::where([
            'email' => $data['email'],
            'otp_code' => $data['otp_code']
        ]);
        $exists = $user->exists();
        if ($exists) {
            if ($user->first()->otp_expires >= now()) {
                $user->update([
                    'otp_code' => null,
                    'otp_expires' => null,
                    'email_verified_at' => now(),
                ]);
                return User::where('email', $data['email'])->first();
            }
            return null;
        }
        return null;
    }

}
