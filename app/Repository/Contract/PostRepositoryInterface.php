<?php

namespace App\Repository\Contract;

interface PostRepositoryInterface
{
    public function getPostById($lang, $id);

    public function showAllPosts($user, $data);

    public function deletePost($id);

    public function updatePost($id, array $data);

    public function createPost(array $data, array $translate);
}
