<?php

namespace App\Service;

use App\Contract\TranslateInterface;
use App\Models\Image;
use App\Repository\Contract\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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

    public function updatePost($id, $request)
    {
        $translate = [];
        foreach (config('app.lang') as $lang) {
            $translate[$lang] = [
                'title' => $this->tranService->translate($request['title'], $lang),
                'content' => $this->tranService->translate($request['content'], $lang),
            ];
        }
        $data = [
            'title' => $request['title'],
            'content' => $request['content'],
        ];
        $image = Image::where('post_id', $id)->get();
        foreach ($image as $item) {
            if (Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            $item->delete();
        }
        $imagePath = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $item) {
                $imagePath[] = $item->store('posts', 'public');
            }
        }
        $post = $this->postRepo->updatePost($id, $data, $imagePath, $translate);
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
