<?php

namespace App\Repository\Eloquent;

use App\Models\Image;
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
        $limit = $data['paginate']['limit'];
        $page = $data['paginate']['page'];
        $maxPage = $data['paginate']['maxPage'];
        $lang = $data['paginate']['lang'];
        $key = $data['fill']['key'];
        $filled = $data['fill']['filled'];

        if ($key === 'time') {
            $key = 'created_at';
        }

        if ($page > $maxPage) {
            return response()->json([
                'error' => 'maxPage',
            ], 400);
        } else {
            if ($user['role_id'] == 1) {
                $list_post = Translate::where('lang', $lang)->orderBy($key, $filled)->paginate($limit);
                return [
                    'data' => $list_post,
                    'paginate' => $list_post,
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
                'paginate' => $list_post,
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

    public function updatePost($id, array $data, array $imagePath, array $translate)
    {
        $post = Post::find($id);
        if (isset($post)) {
            $post->update([
                'title' => $data['title'],
                'content' => $data['content'],
            ]);
            foreach ($imagePath as $item) {
                Image::create([
                    'post_id' => $post->id,
                    'image' => $item,
                ]);
            }
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

    public function searchPosts($title, $data)
    {
        if ($data['page'] > $data['maxPage']) {
            return response()->json([
                'error' => 'maxPage',
            ], 400);
        }
        $list_post = Post::where([
            ['title', 'like', '%' . $title . '%'],
        ])->pluck('id');
        $data = Translate::whereIn('post_id', $list_post)->where('lang', $data['lang'])->paginate($data['limit']);
        return $data;
    }
}
