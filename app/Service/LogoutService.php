<?php

namespace App\Service;

use App\Repository\Contract\UserRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LogoutService
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    public function logoutUser()
    {

        try {
            $user = JWTAuth::user();
            if (isset($user)) {
                JWTAuth::invalidate(JWTAuth::getToken());
                return response()->json([
                    'success' => true,
                    'message' => 'User has been logged out'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to logout, please try again'
            ], 500);
        }
    }
}
