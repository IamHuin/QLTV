<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Service\PaginateService;
use App\Service\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    protected $userService;
    protected $paginateService;


    public function __construct(UserService $userService, PaginateService $paginateService)
    {
        $this->userService = $userService;
        $this->paginateService = $paginateService;
    }

    public function index(Request $request)
    {
        $paginate = $this->paginateService->paginate($request);
        $data = [
            'paginate' => $paginate,
        ];
        try {
            $this->authorize('viewAny', User::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $show = $this->userService->showAllUser($data);
        $dataPaginate = $this->paginateService->dataPaginate($show['paginate']);
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => UserResource::collection($show['data']),
            'meta' => $dataPaginate,
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
        $paginate = $this->paginateService->paginate($request);
        $data = [
            'paginate' => $paginate,
        ];
        try {
            $this->authorize('search', User::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $show = $this->userService->searchUser($data, $request['search']);
        $dataPaginate = $this->paginateService->dataPaginate($show['paginate']);
        if (isset($show)) {
            return response()->json([
                'success' => true,
                'message' => __('Show successfully'),
                'data' => UserResource::collection($show['data']),
                'meta' => $dataPaginate,
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
