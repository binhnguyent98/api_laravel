<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Entities\PostEntity;
use App\Http\Entities\PostQueryEntity;
use App\Http\Requests\IdRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Services\Post\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function fetch(Request $request)
    {
        $filter = new PostQueryEntity(
            (int)$request->page,
            (int)$request->limit,
            $request->title
        );

        $data = $this->postService->fetchPost($filter);

        return $this->buildSuccessResponse(new PostResource($data));
    }

    public function create(PostRequest $request)
    {
        $this->postService->create(new PostEntity(
            $request->title,
            $request->description,
            $request->category_id
        ));

        return $this->buildSuccessResponse();
    }

    public function delete(IdRequest $request)
    {
        $this->postService->delete((int)$request->id);

        return $this->buildSuccessResponse();
    }

    public function detail(IdRequest $request)
    {
        $post = $this->postService->detail((int)$request->id);

        return $this->buildSuccessResponse($post);
    }
}
