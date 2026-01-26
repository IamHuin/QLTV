<?php

namespace App\Service;

use App\Models\Post;
use App\Repository\Contract\PostRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Stichoza\GoogleTranslate\GoogleTranslate;


class PostService
{
    protected $postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function showAllPosts($data)
    {
        $user = JWTAuth::user();
        $posts = $this->postRepo->showAllPosts($user, $data);
        return $posts;
    }

    //Cách 1
    public function getPost($lang, $id)
    {
        $data = $this->postRepo->getPostById($lang, $id);
        return $data;
    }


    public function deletePostById($id)
    {
        $data = $this->postRepo->deletePost($id);
        return $data;
    }

    //Cách 1: Nhận form về là tạo bản dịch lưu vào db
    public function createPost($data)
    {
        $user = JWTAuth::user();
        $language = ['vi', 'en', 'ja'];
        $translate = [];
        foreach ($language as $lang) {
            $tr = new GoogleTranslate($lang);
            $tr->setSource('vi');
            $tr->setTarget($lang);
            $translate[$lang] = [
                'title' => $tr->translate($data['title']),
                'content' => $tr->translate($data['content']),
            ];
        }
        $post = $this->postRepo->createPost([
            'user_id' => $user['id'],
            'title' => $data['title'],
            'content' => $data['content'],
        ], $translate);
        return $post;
    }

    public function updatePost($id, $data)
    {
        $post = $this->postRepo->updatePost($id, [
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
        return $post;
    }
}
