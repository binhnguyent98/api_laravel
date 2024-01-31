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

    public function buildSuccessResponse($data = null, $httpCode = 200)
    {
        $resource = Helper::buildResponse(true, $data);

        return response()->json($resource, $httpCode);
    }


    /**
     * @param array $error = ['key' => '', 'message' => '']
     * @param int|null $statusCode
     * @return JsonResponse
     */
    public function buildFailResponse(array $error = [], int $statusCode = null)
    {
        if (!$statusCode) {
            $statusCode = config('http_status_code.bad_request');
        }

        $resource = Helper::buildResponse(false, null, $error);

        return response()->json($resource, $statusCode);
    }
}
