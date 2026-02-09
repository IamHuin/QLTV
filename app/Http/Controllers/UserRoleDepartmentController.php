<?php

namespace App\Http\Controllers;

use App\Http\Resources\URDResource;
use App\Service\PaginateService;
use App\Service\UserRoleDepartmentService;
use Illuminate\Http\Request;

class UserRoleDepartmentController extends Controller
{
    protected $urdService;
    protected $paginateService;

    public function __construct(UserRoleDepartmentService $urdService, PaginateService $paginateService)
    {
        $this->urdService = $urdService;
        $this->paginateService = $paginateService;
    }

    public function index(Request $request)
    {
        $paginate = $this->paginateService->paginate($request);
        $data = [
            'paginate' => $paginate,
        ];
        $show = $this->urdService->showURD($data);
        $dataPaginate = $this->paginateService->dataPaginate($show['paginate']);
        return response()->json([
            'success' => true,
            'message' => __('Show Successfully'),
            'data' => URDResource::collection($show['data']),
            'meta' => $dataPaginate,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->urdService->createUserRoleDepartment($request);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => __('Create unsuccessfully'),
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => __('Create successfully'),
        ]);
    }
}

