<?php

namespace App\Exceptions;

use App\Utils\Helper;
use Faker\Provider\Base;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException as ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {

        });
    }

    public function render($request, Throwable $e)
    {
        dd($e);
        $statusCode = config('http_status_code.internal_server_error');
        $errorKey = config('error.internal_server_error');
        $message = '';

        switch (true) {
            case $e instanceof NotFoundHttpException:
                $statusCode = config('http_status_code.not_found');
                $errorKey = config('error.route_not_found');
                break;

            case $e instanceof MethodNotAllowedHttpException:
                $statusCode = config('http_status_code.method_not_allowed');
                $errorKey = config('error.method_not_allow');
                break;

            case $e instanceof ValidationException:
                $statusCode = config('http_status_code.bad_request');
                $errorKey = config('error.validator');
                $message = $e->getMessage();
                break;

            case $e instanceof Base:
                $statusCode = 1;
            default:
                break;
        }

        return response()->json(
            Helper::buildFailResponse($errorKey, $message),
            $statusCode
        );
    }
}
