<?php

namespace App\Events;

use App\Http\Entities\NotificationEntity;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationUserEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $notification;
    public $mailable;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, NotificationEntity $notification, Mailable $mailable = null)
    {
        $this->user = $user;
        $this->notification = $notification;
        $this->mailable = $mailable;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
