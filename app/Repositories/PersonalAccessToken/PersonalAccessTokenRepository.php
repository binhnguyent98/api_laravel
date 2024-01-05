<?php

namespace App\Repositories\PersonalAccessToken;

use App\Http\Entities\PersonalAccessTokenEntity;
use App\Models\PersonalAccessToken;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class PersonalAccessTokenRepository extends BaseRepository implements PersonalAccessTokenRepositoryInterface
{

    public function model()
    {
        return PersonalAccessToken::class;
    }

    /**
     * @param PersonalAccessTokenEntity $params
     * @return mixed
     */
    public function create($params)
    {
        $params = [
            'name' => $params->getName(),
            'token' => $params->getToken(),
            'expires_at' => Carbon::now()->addMinutes($params->getExpiresAt()),
            'last_used_at' => now()
        ];

        return new PersonalAccessToken($params);
    }
}
