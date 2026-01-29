<?php

namespace App\Http\Controllers;

use App\Events\PostCreateEvent;
use App\Http\Requests\PostFormRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\TranslateResource;
use App\Models\Post;
use App\Service\PostService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;


class PostController extends Controller
{

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $data = [
            'limit' => max(1, (int)$request->input('limit', 5)),
            'page' => max(1, (int)$request->input('page', 1)),
            'maxPage' => max(1, (int)$request->input('maxPage', 20)),
            'lang' => $request->input('lang', config('app.default_lang')),
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
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => TranslateResource::collection($post['data']),
            'meta' => [
                'current_page' => $post['current_page'],
                'last_page' => $post['last_page'],
                'per_page' => $post['per_page'],
                'total' => $post['total'],
                'prev_page_url' => $post['prev_page_url'],
                'next_page_url' => $post['next_page_url'],
            ],
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
}
