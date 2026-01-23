<?php

namespace App\Repository\Contract;

interface PostRepositoryInterface
{
    //Cách 1
//    public function getPostById($lang, $id);

    //Cách 2
    public function getPostById($id, $tran);

    public function showAllPosts($user);

    public function deletePost($id);

    public function updatePost($id, array $data);
    //Cách 1
//    public function createPost(array $data, array $translate);
    //Cách 2
    public function createPost(array $data);
}
