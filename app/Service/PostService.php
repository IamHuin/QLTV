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

    public function deleteMutiPost($ids)
    {
        return $this->postRepo->deleteMultiPost($ids);
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
        if ($data->hasFile('images')) {
            $imagePath = [];
            foreach ($data->file('images') as $image) {
                $imagePath[] = $image->store('posts', 'public');
            }
        }
        $post = $this->postRepo->createPost([
            'user_id' => $user['id'],
            'title' => $data['title'],
            'content' => $data['content'],
        ], $imagePath, $translate);
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
        $update = [
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => $data['image'],
        ];
        if ($data->hasFile('image')) {
            $update['image'] = $data->file('image')->store('posts', 'public');
        }
        $post = $this->postRepo->updatePost($id, $update, $translate);
        return $post;
    }

    public function updateMultiPost($data)
    {
        $translate = [];
        foreach ($data as $key) {
            foreach (config('app.lang') as $lang) {
                $translate[$key['id']][$lang] = [
                    'title' => $this->tranService->translate($key['title'], $lang),
                    'content' => $this->tranService->translate($key['content'], $lang),
                ];
            }
        }
        return $this->postRepo->updateMultiPost($data, $translate);
    }
}
