<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Service\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $perService;

    public function __construct(PermissionService $perService)
    {
        $this->perService = $perService;
    }

    public function index()
    {
        $data = $this->perService->showPermission();
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'data' => PermissionResource::collection($data),
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => __('Unauthorized')
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->perService->createPermission($request->all());
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Store successfully')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => __('Unauthorized')
        ]);
    }

    public function update($permisson, Request $request)
    {
        $data = $this->perService->updatePermission($permisson, $request->all());
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Update successfully')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => __('Unauthorized')
        ]);
    }

    public function destroy($permission)
    {
        $data = $this->perService->deletePermission($permission);
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Delete successfully')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => __('Unauthorized')
        ]);
    }
}
