<?php

namespace App\Http\Controllers;

use App\Service\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function store(Request $request)
    {
        $data = $this->authService->rolePermission($request->all());
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Store successfully'),
            ], 201);
        }
        return response()->json([
            'success' => false,
            'message' => __('Unauthorized'),
        ], 403);
    }
}
