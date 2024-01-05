<?php

namespace App\Repositories\PersonalAccessToken;


use App\Http\Entities\PersonalAccessTokenEntity;

interface PersonalAccessTokenRepositoryInterface
{
    public function create(PersonalAccessTokenEntity $entity);
}
