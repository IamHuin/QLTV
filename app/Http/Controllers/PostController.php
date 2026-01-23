<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Http\Resources\PostResource;
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

    public function index()
    {
        try {
            $this->authorize('viewAny', Post::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $post = $this->postService->showAllPosts();
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => PostResource::collection($post)
        ], 200);
    }

    //Cách 1
//    public function show(Request $request, Post $post)
//    {
//        $this->authorize('view', $post);
//        $data = $this->postService->getPost($request->lang, $post->id);
//        if (isset($data)) {
//            return response()->json([
//                'success' => true,
//                'message' => __('Show successfully'),
//                'data' => PostResource::collection($data)
//            ], 200);
//        }
//        return response()->json([
//            'success' => false,
//            'message' => __('Unauthorized')
//        ], 403);
//    }

    //Cách 2
    public function show(Request $request, Post $post)
    {
        try {
            $this->authorize('view', $post);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $data = $this->postService->getPost($request, $post->id);
        if (isset($data)) {
            return response()->json([
                'success' => true,
                'message' => __('Show successfully'),
                'data' => new PostResource($data)
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
            ]);
        }
        $this->postService->deletePostById($post->id);
        return response()->json([
            'success' => true,
            'message' => __('Delete successfully'),
        ], 200);
    }

    public function store(PostFormRequest $request)
    {
        try {
            $this->authorize('create', Post::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $this->postService->createPost($request);
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
            ]);
        }
        $this->postService->updatePost($post->id, $request);
        return response()->json([
            'success' => true,
            'message' => __('Update successfully'),
        ], 201);
    }
}
