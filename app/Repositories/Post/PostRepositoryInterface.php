<?php

namespace App\Repositories\Post;

use App\Http\Entities\PostEntity;
use App\Http\Entities\PostQueryEntity;

interface PostRepositoryInterface
{
    public function fetchPost(PostQueryEntity $entity);

    public function createPost(PostEntity $data);

    public function delete($id);
}
