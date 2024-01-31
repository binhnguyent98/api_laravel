<?php

namespace App\Http\Controllers;

use App\Utils\Helper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function buildSuccessResponse($data = null, int $httpCode = 200, string $message = '')
    {
        $resource = Helper::buildSuccessResponse($data, $message);

        return response()->json($resource, $httpCode);
    }


    /**
     * @param string $errorKey
     * @param  ?string $message
     * @param ?int $statusCode
     * @return JsonResponse
     */
    public function buildFailResponse(string $errorKey, ?string $message = '', ?int $statusCode = 400)
    {
        $resource = Helper::buildFailResponse($errorKey,  $message);

        return response()->json($resource, $statusCode);
    }
}
