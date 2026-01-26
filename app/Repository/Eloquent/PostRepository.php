<?php

namespace App\Repository\Eloquent;

use App\Models\Post;
use App\Models\Translate;
use App\Repository\Contract\PostRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class PostRepository implements PostRepositoryInterface
{
    public function getPostById($lang, $id)
    {
        // TODO: Implement getPostById() method.
        $user = JWTAuth::user();
        $post = Post::find($id);
        if ($user['id'] == $post->user_id || $user['role_id'] == 1) {
            if ($lang === 'all') {
                $translate = Translate::where('post_id', $id)->get();
                return $translate;
            } else if (empty($lang)) {
                $translate = Translate::where([
                    ['lang', 'vi'],
                    ['post_id', $id]
                ])->get();
                return $translate;
            } else {
                $translate = Translate::where([
                    ['lang', $lang],
                    ['post_id', $id]
                ])->get();
                return $translate;
            }

        }
        return null;
    }

    public function showAllPosts($user, $data)
    {
        // TODO: Implement showAllPosts() method.
        $limit = 5;
        $page = (int)$data['page'] ?? 1;
        $maxPage = 20;

        if ($page > $maxPage) {
            return response()->json([
                'error' => 'maxPage',
            ], 400);
        } else {
            $lang = $data['lang'] ?? 'vi';
            if ($user['role_id'] == 1) {

                $list_post = Translate::where('lang', $lang)->paginate($limit);
                return [
                    'data' => $list_post,
                    'current_page' => $list_post->currentPage(),
                    'last_page' => $list_post->lastPage(),
                    'per_page' => $list_post->perPage(),
                    'total' => $list_post->total(),
                    'prev_page_url' => $list_post->previousPageUrl(),
                    'next_page_url' => $list_post->nextPageUrl(),
                ];
            }
            $list_post = Post::where('user_id', $user->id)->paginate($limit);
            $show = [];
            foreach ($list_post as $post) {
                $show [] = Translate::where([
                    ['post_id', $post->id],
                    ['lang', $lang],
                ])->first();
            }
            return [
                'data' => $show,
                'current_page' => $list_post->currentPage(),
                'last_page' => $list_post->lastPage(),
                'per_page' => $list_post->perPage(),
                'total' => $list_post->total(),
                'prev_page_url' => $list_post->previousPageUrl(),
                'next_page_url' => $list_post->nextPageUrl(),
            ];
        }

    }

    public function deletePost($id)
    {
        // TODO: Implement deletePost() method.
        $data = Post::find($id)->delete();
        return $data;
    }

    public function createPost(array $data, array $translate)
    {
        $post = Post::create($data);
        foreach ($translate as $key => $value) {
            Translate::create([
                'post_id' => $post->id,
                'lang' => $key,
                'title' => $value['title'],
                'content' => $value['content'],
            ]);
        }
        return $post;
    }

    public function updatePost($id, array $data)
    {
        $post = Post::find($id);
        if (isset($post)) {
            $post->update($data);
            return $post;
        }
        return null;
    }
}
