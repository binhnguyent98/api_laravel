<?php

namespace App\Http\Controllers;

use App\Utils\Helper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function buildSuccessResponse($data = null, ?string $message = '')
    {
        $resource = Helper::buildResponse(true, $message, $data);

        return response()->json($resource, config('http_status_code.success'));
    }

    public function buildFailResponse(string $message = '', int $statusCode = null)
    {
        if (!$statusCode) {
            $statusCode = config('http_status_code.bad_request');
        }

        $resource = Helper::buildResponse(false, $message);

        return response()->json($resource, $statusCode);
    }
}
