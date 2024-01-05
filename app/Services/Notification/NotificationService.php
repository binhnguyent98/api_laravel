<?php

namespace App\Services\Notification;


use App\Http\Entities\NotificationEntity;
use App\Repositories\Notification\NotificationRepositoryInterface;

class NotificationService
{
    private $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function notificationUser(NotificationEntity $entity)
    {
        return $this->notificationRepository->notification($entity);
    }
}
