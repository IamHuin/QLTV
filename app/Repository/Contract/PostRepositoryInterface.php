<?php

namespace App\Repository\Contract;

interface PostRepositoryInterface
{
    public function getPostById($lang, $id);

    public function getPost($id);

    public function showAllPosts($user, $data);

    public function deletePost($id);

    public function updatePost($id, array $data, array $imagePath, array $translate);

    public function createPost(array $data, array $translate);

    public function deleteMultiPost(array $ids);

    public function updateMultiPost(array $data, array $translate);

    public function searchPosts($title, $data);
}
