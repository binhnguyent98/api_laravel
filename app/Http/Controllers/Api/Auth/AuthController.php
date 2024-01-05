<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\BroadcastingNotificationEvent;
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
        try {
            $param = new UserEntity(
                $request->name,
                $request->email,
                $request->password
            );

            $this->authService->register($param);

            return $this->buildSuccessResponse('', 'Register user successfully, please check mail is verify account');
        } catch (\Exception $exception) {
            return $this->buildFailResponse($exception->getMessage());
        }
    }

    public function verify(VerifyUserRequest $request)
    {
        try {
            $this->authService->verify($request->token);

            return $this->buildSuccessResponse('', 'Verify account successfully');
        } catch (\Exception $exception) {
            return $this->buildFailResponse($exception->getMessage());
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
            return $this->buildFailResponse($exception->getMessage());
        }
    }

    public function renewToken($refreshToken)
    {
        try {
            $data = $this->authService->renewToken($refreshToken);
            $resource = new LoginResource($data);

            return $this->buildSuccessResponse($resource->resource);
        } catch (\Exception $exception) {
            return $this->buildFailResponse($exception->getMessage(), config('http_status_code.unauthorized'));
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
