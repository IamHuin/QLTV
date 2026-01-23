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

    //Đăng ký
    public function register(RegisterFormRequest $request)
    {
        $data = $this->registerService->registerUser($request);
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Register successfully'),
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => __('Register unsuccessfully'),
        ]);
    }

    //Đăng nhập

    public function login(LoginFormRequest $request)
    {
        $data = $this->loginService->loginUser($request);
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Login successfully'),
                'token' => $data['token'],
                'expiresIn' => JWTAuth::factory()->getTTL() * 60,
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => __('Login unsuccessfully'),
        ]);
    }

    //Đăng xuất
    public function logout()
    {
        return $this->loginService->logoutUser();
    }


    //Hiển thị ds thành viên
    public function index()
    {
        try {
            $this->authorize('viewAny', User::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $show = $this->userService->showAllUser();
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => UserResource::collection($show),
        ]);

    }

    //Chi tiết thành viên
    public function show(User $user)
    {
        try {
            $this->authorize('view', $user);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $show = $this->userService->showUser($user['id']);
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => new UserResource($show),
        ]);
    }

    //Tìm kiếm thành viên
    public function find(Request $request)
    {
        try {
            $this->authorize('search', User::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $show = $this->userService->searchUser($request['username']);
        if (isset($show)) {
            return response()->json([
                'success' => true,
                'message' => __('Show successfully'),
                'data' => new UserResource($show),
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => __('Show unsuccessfully'),
        ]);

    }

    //Đổi password
    public function update(UpdateFormRequest $request, User $user)
    {
        try {
            $this->authorize('update', $user);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $this->userService->updateUser($request, $user['id']);

        return response()->json([
            'success' => true,
            'message' => __('Update successfully'),
        ]);

    }

    //Xóa thành viên
    public function destroy(User $user)
    {
        try {
            $this->authorize('delete', $user);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $this->userService->deleteUser($user['id']);
        return response()->json([
            'success' => true,
            'message' => __('Delete successfully'),
        ]);
    }


}
