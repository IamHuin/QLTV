<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Service\LoginService;
use App\Service\LogoutService;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    protected $loginService;
    protected $logoutService;

    public function __construct(LoginService $loginService, LogoutService $logoutService)
    {
        $this->loginService = $loginService;
        $this->logoutService = $logoutService;
    }

    public function login(LoginFormRequest $request)
    {
        $data = $this->loginService->loginUser($request);
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Login successfully'),
                'token_type' => 'bearer',
                'token' => $data['token'],
                'expiresIn' => JWTAuth::factory()->getTTL() * 60,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => __('Login unsuccessfully'),
        ], 400);
    }

    public function logout()
    {
        return $this->logoutService->logoutUser();
    }
}
