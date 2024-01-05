<?php

namespace App\Http\Entities;

use Illuminate\Support\Facades\Hash;

class LoginEntity
{
    public function __construct(
        private string $email,
        private string $password,
    )
    { }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

}
