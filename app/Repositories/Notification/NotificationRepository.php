<?php

namespace App\Repositories\Notification;

use App\Http\Entities\NotificationEntity;
use App\Models\Notification;
use App\Repositories\BaseRepository;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{

    public function model()
    {
        return Notification::class;
    }

    public function notification(NotificationEntity $entity)
    {
        $params = [
            'content' => $entity->getContent(),
            'description' => $entity->getDescription(),
            'type' => $entity->getType(),
            'user_id' => $entity->getForUser()
        ];

        return parent::create($params);
    }
}
