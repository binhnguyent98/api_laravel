<?php

namespace App\Http\Entities;

use Illuminate\Support\Facades\Hash;

class NotificationEntity
{
    public function __construct(
        private string $content,
        private string $description,
        private string $type,
        private string $forUser,
        private ?bool $isRead = false,

    )
    { }

    public function getContent()
    {
        return $this->content;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getIsRead()
    {
        return $this->isRead;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getForUser()
    {
        return (int)$this->forUser;
    }
}
