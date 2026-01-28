<?php

namespace App\Service;

use App\Contract\TranslateInterface;
use App\Repository\Contract\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class PostService
{
    protected $postRepo;
    protected $tranService;

    public function __construct(PostRepositoryInterface $postRepo, TranslateInterface $tranService)
    {
        $this->postRepo = $postRepo;
        $this->tranService = $tranService;
    }

    public function showAllPosts($data)
    {
        $user = Auth::user();
        $posts = $this->postRepo->showAllPosts($user, $data);
        return $posts;
    }

    public function getPostById($lang, $id)
    {
        $data = $this->postRepo->getPostById($lang, $id);
        return $data;
    }

    public function getPost($id)
    {
        return $this->postRepo->getPost($id);
    }

    public function deletePostById($id)
    {
        $data = $this->postRepo->deletePost($id);
        return $data;
    }

    public function createPost($data)
    {
        $user = Auth::user();
        $translate = [];
        foreach (config('app.lang') as $lang) {
            $translate[$lang] = [
                'title' => $this->tranService->translate($data['title'], $lang),
                'content' => $this->tranService->translate($data['content'], $lang),
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
        $translate = [];
        foreach (config('app.lang') as $lang) {
            $translate[$lang] = [
                'title' => $this->tranService->translate($data['title'], $lang),
                'content' => $this->tranService->translate($data['content'], $lang),
            ];
        }
        $post = $this->postRepo->updatePost($id, [
            'title' => $data['title'],
            'content' => $data['content'],
        ], $translate);
        return $post;
    }
}
