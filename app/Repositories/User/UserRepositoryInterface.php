<?php

namespace App\Repositories\User;

use App\Http\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function createUser(UserEntity $entity);
    public function verifyUser(string $id);

    public function renewToken(string $id, string $token);
}
