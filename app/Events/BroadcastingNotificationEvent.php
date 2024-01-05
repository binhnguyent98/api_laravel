<?php

namespace App\Events;

use App\Http\Resources\NotificationResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class BroadcastingNotificationEvent implements ShouldBroadcastNow
{
    use SerializesModels;

    public $notice;

    /**a
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(NotificationResource $notificationResource)
    {
        $this->notice = $notificationResource->resource;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('user-notification');
    }
}
