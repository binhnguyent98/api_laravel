<?php

namespace App\Http\Middleware;

use App\Utils\Helper;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomAuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = JWTAuth::parseToken();
            $payload = $token->getPayload();

            $isRefresh = $payload->get('refreshToken') || false;

            if ($isRefresh) {
                throw new \Exception('Token invalid');
            }

            return $next($request);
        } catch (\Exception $exception) {
            $response = Helper::buildResponse(false, null, ['key' => config('error.forbidden')]);

            return response()->json($response, config('http_status_code.unauthorized'));
        }
    }
}
