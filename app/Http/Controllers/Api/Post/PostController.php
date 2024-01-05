<?php

namespace App\Http\Controllers\Api\Post;

use App\Events\NotificationUserEvent;
use App\Http\Controllers\Controller;
use App\Http\Entities\NotificationEntity;
use App\Http\Entities\PostEntity;
use App\Http\Entities\PostQueryEntity;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Mail\RegisterSuccessUserMail;
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
        try {
            $this->postService->create(new PostEntity(
                $request->title,
                $request->description,
                $request->category_id
            ));

            return $this->buildSuccessResponse('', 'Create posts successfully');
        } catch (\Exception $exception) {
            return $this->buildFailResponse($exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->postService->delete((int)$id);

            return $this->buildSuccessResponse('', 'Post is deleted');
        } catch (\Exception $exception) {
            return $this->buildFailResponse($exception->getMessage());

        }
    }
}
