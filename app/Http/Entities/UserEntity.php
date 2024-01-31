<?php

namespace App\Http\Entities;

use Illuminate\Support\Facades\Hash;

class UserEntity
{
    public function __construct(
        private string $email,
        private string $password,
        private ?string $name,
    )
    { }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getHasPassword()
    {
        return Hash::make($this->password);
    }
}
