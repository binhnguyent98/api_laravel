<?php

namespace App\Http\Entities;

use Illuminate\Support\Facades\Hash;

class PersonalAccessTokenEntity
{
    public function __construct(
        private string $name,
        private string $token,
        private string $expires_at
    )
    { }

    public function getName()
    {
        return $this->name;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getExpiresAt(): int
    {
        return (int)$this->expires_at;
    }
}
