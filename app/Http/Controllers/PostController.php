<?php

namespace App\Http\Controllers;

use App\Events\PostCreateEvent;
use App\Http\Requests\PostFormRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\TranslateResource;
use App\Models\Post;
use App\Service\FillterService;
use App\Service\ImageService;
use App\Service\PaginateService;
use App\Service\PostService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class PostController extends Controller
{

    protected $postService;
    protected $imgService;
    protected $paginateService;
    protected $fillService;

    public function __construct(PostService $postService, ImageService $imgService, PaginateService $paginateService, FillterService $fillService)
    {
        $this->postService = $postService;
        $this->imgService = $imgService;
        $this->paginateService = $paginateService;
        $this->fillService = $fillService;
    }

    public function index(Request $request)
    {
        $paginate = $this->paginateService->paginate($request);
        $fill = $this->fillService->fill($request);
        $data = [
            'paginate' => $paginate,
            'fill' => $fill,
        ];
        try {
            $this->authorize('viewAny', Post::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $post = $this->postService->showAllPosts($data);
        $dataPagination = $this->paginateService->dataPaginate($post['paginate']);
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => TranslateResource::collection($post['data']),
            'meta' => $dataPagination,
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $post = $this->postService->getPost($id);
        try {
            $this->authorize('view', $post);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $data = $this->postService->getPostById($request->lang, $id);
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => $request->lang ? TranslateResource::collection($data) : PostResource::collection($data),
        ], 200);
    }

    public function destroy($id)
    {
        $post = $this->postService->getPost($id);
        try {
            $this->authorize('delete', $post);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $this->postService->deletePostById($id);
        return response()->json([
            'success' => true,
            'message' => __('Delete successfully'),
        ], 204);
    }

    public function destroyMulti(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => __('Invalid')
            ]);
        }
        $this->postService->deleteMutiPost($ids);
        return response()->json([
            'success' => true,
            'message' => __('Delete successfully')
        ]);
    }

    public
    function store(PostFormRequest $request)
    {
        try {
            $this->authorize('create', Post::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $post = $this->postService->createPost($request);
        $img = $this->imgService->createImage($request, $post->id);
        event(new PostCreateEvent($post));
        return response()->json([
            'success' => true,
            'message' => __('Store successfully'),
            'data' => new PostResource($post),
        ], 201);
    }

    public function update($id, PostFormRequest $request)
    {
        $post = $this->postService->getPost($id);
        try {
            $this->authorize('update', $post);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $this->postService->updatePost($id, $request);
        return response()->json([
            'success' => true,
            'message' => __('Update successfully'),
        ], 204);
    }

    public function multiUpdate(Request $request)
    {
        $data = $request->input('data');
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => __('Invalid')
            ]);
        }
        $this->postService->updateMultiPost($data);
        return response()->json([
            'success' => true,
            'message' => __('Update successfully')
        ]);
    }

    public function search(Request $request)
    {
        $data = $this->paginateService->paginate($request);
        try {
            $this->authorize('search', Post::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $list_post = $this->postService->searchPosts($request->input('title', ''), $data);
        if (!$list_post->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => __('Show successfully'),
                'data' => TranslateResource::collection($list_post),
                'meta' => [
                    'current_page' => $list_post->currentPage(),
                    'last_page' => $list_post->lastPage(),
                    'per_page' => $list_post->perPage(),
                    'total' => $list_post->total(),
                    'prev_page_url' => $list_post->previousPageUrl(),
                    'next_page_url' => $list_post->nextPageUrl(),
                ],
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => __('Show unsuccessfully'),
        ]);
    }
}
