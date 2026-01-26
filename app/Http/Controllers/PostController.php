<?php

namespace App\Http\Controllers;

use App\Events\PostCreateEvent;
use App\Http\Requests\PostFormRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\TranslateResource;
use App\Models\Post;
use App\Service\PostService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class PostController extends Controller
{

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Post::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $post = $this->postService->showAllPosts($request);
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

    //Cách 1
    public function show(Request $request, Post $post)
    {
        try {
            $this->authorize('view', $post);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $data = $this->postService->getPost($request->lang, $post->id);
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Show successfully'),
                'data' => PostResource::collection($data)
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => __('Unauthorized')
        ], 403);
    }

    public function destroy(Post $post)
    {
        try {
            $this->authorize('delete', Post::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $this->postService->deletePostById($post->id);
        return response()->json([
            'success' => true,
            'message' => __('Delete successfully'),
        ], 204);
    }

    public function store(PostFormRequest $request)
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
        ], 201);
    }

    public function update(Post $post, PostFormRequest $request)
    {
        try {
            $this->authorize('update', $post);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
        $this->postService->updatePost($post->id, $request);
        return response()->json([
            'success' => true,
            'message' => __('Update successfully'),
        ], 204);
    }
}
