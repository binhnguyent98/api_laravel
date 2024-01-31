<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\BroadcastingNotificationEvent;
use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Entities\LoginEntity;
use App\Http\Entities\UserEntity;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\NotificationResource;
use App\Models\User;
use App\Services\Auth\AuthService;
class AuthController extends Controller
{

    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request)
    {
        $param = new UserEntity(
            $request->name,
            $request->email,
            $request->password
        );

        $this->authService->register($param);

        return $this->buildSuccessResponse();
    }

    public function verify(VerifyUserRequest $request)
    {
        try {
            $this->authService->verify($request->token);

            return $this->buildSuccessResponse();
        } catch (\Exception $exception) {
            return $this->buildFailResponse(['message' => $exception->getMessage(), 'key' => config('error.token_invalid')]);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $param = new LoginEntity($request->email, $request->password);
            $data = $this->authService->login($param);
            $resource = new LoginResource($data);

            return $this->buildSuccessResponse($resource->resource);
        } catch (\Exception $exception) {
            return $this->buildFailResponse(['message' => $exception->getMessage(), 'key' => config('error.login_fail')]);
        }
    }

    public function renewToken($refreshToken)
    {
        try {
            $data = $this->authService->renewToken($refreshToken);
            $resource = new LoginResource($data);

            return $this->buildSuccessResponse($resource->resource);
        } catch (\Exception $exception) {
            return $this->buildFailResponse(['message' => $exception->getMessage(), 'key' => config('error.login_fail')]);
        }
    }

    public function test()
    {
        $user = new NotificationResource([
            'content' => 1,
            'description' => 2,
            'is_read' => 2,
            'type' => 12
        ]);

        broadcast(new BroadcastingNotificationEvent($user));
    }
}
