<?php

namespace App\Repositories\Post;

use App\Http\Entities\PostEntity;
use App\Http\Entities\PostQueryEntity;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{

    public function model()
    {
        return Post::class;
    }

    public function fetchPost(PostQueryEntity $entity)
    {
        $query = $this->model
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'categories.title as category_name');

        if ($entity->getQueryTitle()) {
            $query = $query->where('posts.title', 'like', '%'.$entity->getQueryTitle().'%');
        }
        return $query->paginate($entity->getLimit(), $entity->getPage());

    }

    public function createPost(PostEntity $data)
    {
        try {
            $category = (new Category())->find($data->getCategoryId());

            if(!$category) throw new \Exception('Category not found');

            $param = [
                'title' => $data->getTitle(),
                'description' => $data->getDescription(),
                'category_id' => $category->id
            ];

            return $this->create($param);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function delete($id)
    {
        return $this->destroy($id);
    }

    public function find($id)
    {
        return Post::find($id);
    }
}
