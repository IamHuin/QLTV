<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Service\AuthService;
use App\Service\LoginService;
use App\Service\LogoutService;
use App\Service\RegisterService;
use App\Service\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    protected $userService;
    protected $loginService;
    protected $registerService;
    protected $logoutService;

    public function __construct(UserService $userService, LoginService $loginService, RegisterService $registerService, LogoutService $logoutService)
    {
        $this->userService = $userService;
        $this->loginService = $loginService;
        $this->registerService = $registerService;
        $this->logoutService = $logoutService;
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

    public function login(LoginFormRequest $request)
    {
        $data = $this->loginService->loginUser($request);
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Login successfully'),
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
        return $this->loginService->logoutUser();
    }

    public function index()
    {
        try {
            $this->authorize('viewAny', User::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $show = $this->userService->showAllUser();
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => UserResource::collection($show),
        ], 200);

    }

    public function show($id)
    {
        $user = $this->userService->showUser($id);
        try {
            $this->authorize('view', $user);
            return response()->json([
                'success' => true,
                'message' => __('Show successfully'),
                'data' => new UserResource($user),
            ], 200);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function search(Request $request)
    {
        try {
            $this->authorize('search', User::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $show = $this->userService->searchUser($request['username']);
        if (isset($show)) {
            return response()->json([
                'success' => true,
                'message' => __('Show successfully'),
                'data' => new UserResource($show),
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => __('Show unsuccessfully'),
        ], 404);

    }

    public function update(UpdateFormRequest $request, $id)
    {
        $user = $this->userService->showUser($id);
        try {
            $this->authorize('update', $user);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $this->userService->updateUser($request, $id);

        return response()->json([
            'success' => true,
            'message' => __('Update successfully'),
        ], 204);

    }

    public function destroy($id)
    {
        $user = $this->userService->showUser($id);
        try {
            $this->authorize('delete', $user);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $this->userService->deleteUser($id);
        return response()->json([
            'success' => true,
            'message' => __('Delete successfully'),
        ], 204);
    }


}
