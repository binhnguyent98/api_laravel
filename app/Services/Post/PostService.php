<?php

namespace App\Services\Post;

use App\Events\NotificationUserEvent;
use App\Http\Entities\NotificationEntity;
use App\Http\Entities\PostEntity;
use App\Http\Entities\PostQueryEntity;
use App\Repositories\Post\PostRepositoryInterface;
use App\Services\BaseService;

class PostService extends BaseService
{
    private $postRepository;

    public function __construct(
        PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function fetchPost(PostQueryEntity $entity)
    {
        return $this->postRepository->fetchPost($entity);
    }

    public function create(PostEntity $data)
    {
        try {
            $post = $this->postRepository->createPost($data);
            $user = auth()->user();
            $notification = new NotificationEntity(
                'Create post successfully:',
                'Create post'.$post->title,
                config('notification.notification_type.create_post'),
                $user->id
            );

            event(new NotificationUserEvent($user, $notification));
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function delete($id)
    {
        return $this->postRepository->delete($id);
    }

    public function detail($id)
    {
        return $this->postRepository->find($id);
    }
}
