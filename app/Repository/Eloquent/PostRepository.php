<?php

namespace App\Repository\Eloquent;

use App\Models\Post;
use App\Models\Translate;
use App\Repository\Contract\PostRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Stichoza\GoogleTranslate\GoogleTranslate;

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
                $translate = Post::where([
                    ['id', $id]
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

    public function getPost($id)
    {
        return Post::find($id);
    }

    public function showAllPosts($user, $data)
    {
        // TODO: Implement showAllPosts() method.
        $limit = $data['limit'];
        $page = $data['page'];
        $maxPage = $data['maxPage'];

        if ($page > $maxPage) {
            return response()->json([
                'error' => 'maxPage',
            ], 400);
        } else {
            $lang = $data['lang'];
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
        Translate::where('post_id', $id)->delete();
        return $data;
    }

    public function createPost(array $data, array $translate)
    {
        $post = Post::create($data);
        foreach ($translate as $lang => $value) {
            Translate::create([
                'post_id' => $post->id,
                'lang' => $lang,
                'title' => $value['title'],
                'content' => $value['content'],
            ]);
        }
        return $post;
    }

    public function updatePost($id, array $data, array $translate)
    {
        $post = Post::find($id);
        if (isset($post)) {
            $post->update($data);
            foreach ($translate as $lang => $value) {
                Translate::where([
                    ['post_id', $id],
                    ['lang', $lang],
                ])->update([
                    'title' => $value['title'],
                    'content' => $value['content'],
                ]);
            }
            return $post;
        }
        return null;
    }

    public function deleteMultiPost(array $ids)
    {
        // TODO: Implement deleteMultiPost() method.
        Post::whereIn('id', $ids)->delete();
        Translate::whereIn('post_id', $ids)->delete();
    }

    public function updateMultiPost(array $data, array $translate)
    {
        // TODO: Implement updateMultiPost() method.
        foreach ($data as $key) {
            $post = Post::where('id', $key['id'])->update([
                'title' => $key['title'],
                'content' => $key['content'],
            ]);
            foreach ($translate[$key['id']] as $lang => $value) {
                Translate::where([
                    ['post_id', $key['id']],
                    ['lang', $lang],
                ])->update([
                    'title' => $value['title'],
                    'content' => $value['content'],
                ]);
            }
        }

    }
}
