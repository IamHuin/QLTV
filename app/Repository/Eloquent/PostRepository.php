<?php

namespace App\Repository\Eloquent;

use App\Models\Post;
use App\Models\Translate;
use App\Repository\Contract\PostRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class PostRepository implements PostRepositoryInterface
{
    //Cách 1
//    public function getPostById($lang, $id)
//    {
//        // TODO: Implement getPostById() method.
//        $user = JWTAuth::user();
//        $post = Post::find($id);
//        if ($user['id'] == $post->user_id || $user['role_id'] == 1) {
//            if ($lang === 'all') {
//                $translate = Translate::where('post_id', $id)->get();
//                return $translate;
//            } else if (empty($lang)) {
//                $translate = Translate::where([
//                    ['lang', 'vi'],
//                    ['post_id', $id]
//                ])->get();
//                return $translate;
//            } else {
//                $translate = Translate::where([
//                    ['lang', $lang],
//                    ['post_id', $id]
//                ])->get();
//                return $translate;
//            }
//
//        }
//        return null;
//    }

    //Cách 2
    public function getPostById($id, $tran)
    {
        // TODO: Implement getPostById() method.
        $post = Post::find($id);
        $tranTitle = $tran->translate($post->title);
        $tranContent = $tran->translate($post->content);
        $post->title = $tranTitle;
        $post->content = $tranContent;
        return $post;
    }

    public function showAllPosts($user)
    {
        // TODO: Implement showAllPosts() method.
        if ($user['role_id'] == 1) {
            return Post::paginate(5);
        }
        return Post::where('user_id', $user->id)->paginate(5);
    }

    public function deletePost($id)
    {
        // TODO: Implement deletePost() method.
        $data = Post::find($id)->delete();
        return $data;
    }

    //Cách 1
//    public function createPost(array $data, array $translate)
//    {
//        $post = Post::create($data);
//        foreach ($translate as $key => $value) {
//            Translate::create([
//                'post_id' => $post->id,
//                'lang' => $key,
//                'title' => $value['title'],
//                'content' => $value['content'],
//            ]);
//        }
//        return $post;
//    }

    //Cách 2
    public function createPost(array $data)
    {
        $post = Post::create($data);
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
