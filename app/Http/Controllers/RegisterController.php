<?php

namespace App\Http\Controllers;

use App\Events\RegisterEvent;
use App\Http\Requests\RegisterFormRequest;
use App\Service\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function register(RegisterFormRequest $request)
    {
        $data = $this->registerService->registerUser($request);
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Register successfully'),
            ], 201);
        }
        return response()->json([
            'success' => false,
            'message' => __('Register unsuccessfully'),
        ], 400);
    }

    public function verify(Request $request)
    {
        $data = $this->registerService->verify($request);
        if (isset($data)) {

            return response()->json([
                'success' => true,
                'message' => __('Verify successfully'),
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => __('Verify unsuccessfully'),
        ]);
    }
}
