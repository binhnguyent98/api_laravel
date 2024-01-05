<?php

namespace App\Exceptions;

use App\Utils\Helper;
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
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof  MethodNotAllowedHttpException) {
            $failResource = Helper::buildResponse(false, 'Method is not supported', '', $e->getMessage());

            return response()->json($failResource, config('http_status_code.method_not_allowed'));
        }

        if ($e instanceof ValidationException) {
            $failResource = Helper::buildResponse(false, 'Bad request', '', $e->getMessage());

            return response()->json($failResource, config('http_status_code.bad_request'));
        }

        if ($e instanceof NotFoundHttpException) {
            $failResource = Helper::buildResponse(false, 'Api not found');

            return response()->json($failResource, config('http_status_code.not_found'));
        }

        if ($this->isHttpException($e) && $e->getStatusCode() == 500) {
            $failResource = Helper::buildResponse(false, 'Internal Server Error');

            return response()->json($failResource, config('http_status_code.internal_server_error'));
        }

        return parent::render($request, $e);
    }
}
