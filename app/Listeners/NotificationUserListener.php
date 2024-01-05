<?php

namespace App\Listeners;

use App\Events\NotificationUserEvent;
use App\Services\Notification\NotificationService;
use Illuminate\Support\Facades\Mail;

class NotificationUserListener
{
    private $notificationService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotificationUserEvent $event)
    {
        $this->notificationService->notificationUser($event->notification);

        if ($event->mailable) {
            Mail::to($event->user->email)->send($event->mailable);
        }
    }
}
