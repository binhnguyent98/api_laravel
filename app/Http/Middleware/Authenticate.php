<?php

namespace App\Http\Middleware;

use App\Utils\Helper;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $response = Helper::buildResponse(false, '', '', 'Unauthorized');

        abort(response()->json($response, config('http_status_code.unauthorized')));
    }
}
