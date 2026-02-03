<?php

namespace App\Service;

use App\Events\NotiRegisterEvent;
use App\Events\VerifyRegisterEvent;
use App\Repository\Contract\RegisterRepositoryInterface;

class RegisterService
{
    protected $registerRepo;

    public function __construct(RegisterRepositoryInterface $registerRepo)
    {
        $this->registerRepo = $registerRepo;
    }

    public function registerUser($data)
    {
        $user = $this->registerRepo->register([
            'role_id' => 2,
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'email' => $data['email'],
            'otp_code' => rand(1000, 9999),
            'otp_expires' => date("Y-m-d H:i:s", strtotime("+30 minutes"))
        ]);
        event(new VerifyRegisterEvent($user));
        return $user;
    }

    public function verify($data)
    {
        $verify = $this->registerRepo->verifyEmail($data);
        if (isset($verify)) {
            event(new NotiRegisterEvent($verify));
            return $verify;
        }
        return null;
    }
}
