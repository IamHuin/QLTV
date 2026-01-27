<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupFormRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Service\GroupService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class GroupController extends Controller
{

    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function store(GroupFormRequest $request)
    {
        try {
            $this->authorize('create', Group::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $this->groupService->createGroup($request->validated());
        return response()->json([
            'success' => true,
            'message' => __('Store Successfully'),
        ], 201);
    }

    public function index()
    {
        try {
            $this->authorize('viewAny', Group::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $group = $this->groupService->showAllGroups();
        return response()->json([
            'success' => true,
            'message' => __('Show Successfully'),
            'data' => GroupResource::collection($group)
        ], 200);
    }

    public function show($id)
    {
        $group = $this->groupService->getGroup($id);
        try {
            $this->authorize('view', $group);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        return response()->json([
            'success' => true,
            'message' => __('Show Successfully'),
            'data' => new GroupResource($group)
        ], 200);
    }

    public function update($id, GroupFormRequest $request)
    {
        $group = $this->groupService->getGroup($id);
        try {
            $this->authorize('update', $group);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $this->groupService->updateGroup($id, $request);
        return response()->json([
            'success' => true,
            'message' => __('Update Successfully'),
        ], 204);
    }

    public function destroy($id)
    {
        $group = $this->groupService->getGroup($id);
        try {
            $this->authorize('delete', $group);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $this->groupService->deleteGroup($id);
        return response()->json([
            'success' => true,
            'message' => __('Delete Successfully'),
        ], 204);
    }

    public function join($id)
    {
        $group = $this->groupService->getGroup($id);
        try {
            $this->authorize('join', $group);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $this->groupService->joinGroup($id);
        return response()->json([
            'success' => true,
            'message' => __('Joined Successfully')
        ], 201);
    }
}
