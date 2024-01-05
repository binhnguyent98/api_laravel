<?php

namespace App\Repositories\Notification;


use App\Http\Entities\NotificationEntity;

interface NotificationRepositoryInterface
{
    public function notification(NotificationEntity $entity);
}
