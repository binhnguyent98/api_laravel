<?php

namespace App\Services\Auth;

use App\Events\NotificationUserEvent;
use App\Exceptions\ApiErrorException;
use App\Http\Entities\LoginEntity;
use App\Http\Entities\NotificationEntity;
use App\Http\Entities\PersonalAccessTokenEntity;
use App\Http\Entities\UserEntity;
use App\Mail\RegisterSuccessUserMail;
use App\Repositories\PersonalAccessToken\PersonalAccessTokenRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    use Queueable;
    private $userRepository;
    private $personalRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PersonalAccessTokenRepositoryInterface $personalRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->personalRepository = $personalRepository;
    }

    public function register(UserEntity $entity)
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepository->createUser($entity);

            if ($user) {
                $token = auth()->login($user);
                $notification = new NotificationEntity(
                    'Create account success',
                    'Create account success',
                    config('notification.notification_type.create_account'),
                    $user->id
                );

                event(new NotificationUserEvent($user, $notification, new RegisterSuccessUserMail($user, $token)));
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function verify($token)
    {
        $token = JWTAuth::setToken($token)->getPayload();

        return $this->userRepository->verifyUser($token->get('sub'));
    }

    public function login(LoginEntity $entity)
    {
        try {
            DB::beginTransaction();
            $attemptInfo = [
                'email' => $entity->getEmail(),
                'password' => $entity->getPassword()
            ];

            $accessToken = auth('api')->attempt($attemptInfo);
            $user = auth()->user();

            if (!$accessToken) {
                throw new ApiErrorException(config('error.login_incorrect'));
            }

            $payload = [
                'refreshToken' => true,
                'exp' => Carbon::now()->addMinutes(config('jwt.refresh_ttl'))
            ];

            $refreshToken = JWTAuth::customClaims($payload)->fromUser($user);
            $user = $user->refresh();

            if (!$user->hasVerifiedEmail()) {
                throw new ApiErrorException(config('error.user_must_verify'));
            }

            $personalToken = $this->personalRepository->create(new PersonalAccessTokenEntity(
                'refresh_token',
                $refreshToken,
                config('jwt.refresh_ttl')
            ));
            $user->personalAccessTokens()->save($personalToken);

            DB::commit();

            return [
                'accessToken' => $accessToken,
                'refreshToken' => $personalToken->token
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function renewToken($refreshToken)
    {
        $token = JWTAuth::setToken($refreshToken)->getPayload();
        $user = $this->userRepository->renewToken($token->get('sub'), $refreshToken);

        return JWTAuth::customClaims(['refreshToken' => false])->fromUser($user);
    }
}
