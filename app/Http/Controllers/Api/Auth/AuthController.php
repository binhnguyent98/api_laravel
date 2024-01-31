<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Entities\LoginEntity;
use App\Http\Entities\UserEntity;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\TokenRequest;
use App\Http\Resources\LoginResource;
use App\Services\Auth\AuthService;
class AuthController extends Controller
{

    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request)
    {
        $param = new UserEntity(
            $request->email,
            $request->password,
            $request->name,
        );

        $this->authService->register($param);

        return $this->buildSuccessResponse();
    }

    public function verify(TokenRequest $request)
    {
        $this->authService->verify($request->token);

        return $this->buildSuccessResponse();
    }

    public function login(LoginRequest $request)
    {
        $param = new LoginEntity($request->email, $request->password);
        $data = $this->authService->login($param);
        $resource = new LoginResource($data);

        return $this->buildSuccessResponse($resource->resource);
    }

    public function renewToken(TokenRequest $request)
    {
        $accessToken = $this->authService->renewToken($request->token);
        $resource = new LoginResource(['accessToken' => $accessToken]);

        return $this->buildSuccessResponse($resource->resource);
    }
}
