<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Service\DepartmentService;
use App\Service\PaginateService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departService;
    protected $paginateService;

    public function __construct(DepartmentService $departService, PaginateService $paginateService)
    {
        $this->departService = $departService;
        $this->paginateService = $paginateService;
    }

    public function index(Request $request)
    {
        $paginate = $this->paginateService->paginate($request);
        $data = [
            'paginate' => $paginate,
        ];
        try {
            $this->authorize('viewAny', Department::class);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
        $show = $this->departService->getAll($data);
        $dataPaginate = $this->paginateService->dataPaginate($show['paginate']);
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => DepartmentResource::collection($show['data']),
            'meta' => $dataPaginate,
        ]);
    }

    public function store(DepartmentRequest $request)
    {
        try {
            $this->authorize('create', Department::class);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
        $data = $request->input('name');
        $this->departService->create($data);
        return response()->json([
            'success' => true,
            'message' => __('Created successfully')
        ]);
    }

    public function show($id)
    {
        $department = $this->departService->getById($id);
        try {
            $this->authorize('view', $department);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => $department,
        ]);
    }

    public function update(DepartmentRequest $request, $id)
    {
        $department = $this->departService->getById($id);
        try {
            $this->authorize('update', $department);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
        $data = $request->input('name');
        $this->departService->update($data, $id);
        return response()->json([
            'success' => true,
            'message' => __('Updated successfully')
        ]);
    }

    public function destroy($id)
    {
        $department = $this->departService->getById($id);
        try {
            $this->authorize('delete', $department);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
        $this->departService->delete($id);
        return response()->json([
            'success' => true,
            'message' => __('Deleted successfully')
        ]);
    }

    public function search(Request $request)
    {
        $paginate = $this->paginateService->paginate($request);
        $data = [
            'paginate' => $paginate,
        ];
        $search = $request->input('search');
        try {
            $this->authorize('search', Department::class);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
        $show = $this->departService->search($data, $search);
        $dataPaginate = $this->paginateService->dataPaginate($show['paginate']);
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => DepartmentResource::collection($show['data']),
            'meta' => $dataPaginate,
        ]);
    }
}
