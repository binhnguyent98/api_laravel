<?php

namespace App\Repositories\User;

use App\Exceptions\ApiErrorException;
use App\Http\Entities\UserEntity;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function model()
    {
        return User::class;
    }

    public function createUser(UserEntity $entity)
    {
        $existedUser = $this->model->where('email', '=', $entity->getEmail())->first();

        if ($existedUser) {
            throw new ApiErrorException(config('error.user_is_existed'));
        }

        $data = [
            'email' => $entity->getEmail(),
            'name' => $entity->getName(),
            'password' => $entity->getHasPassword()
        ];

        return $this->create($data);
    }

    public function verifyUser(string $id)
    {
        $user = $this->find($id);

        if (!$user) throw new ApiErrorException(config('error.token_invalid'));

        if ($user->email_verified_at) throw new ApiErrorException(config('error.user_is_verified'));

        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();

        return $user;
    }

    public function renewToken(string $id, string $token)
    {
        $user = $this->model
            ->where('id', '=', $id)
            ->whereHas('personalAccessTokens', function ($query) use ($token) {
                $query
                    ->where('tokenable_type', 'App\Models\User')
                    ->where('token', '=', $token)
                    ->where('expires_at', '>=', Carbon::now());
            })
            ->first();

        if (!$user) throw new \Exception('Token is expired');

        return $user;
    }
}
