<?php

namespace App\Utils;

use App\Http\Resources\BaseResponseResource;

class Helper
{
    /**
     * @param array $params
     * @return string
     */
    public static function convertParamsToQueryString(array $params): string
    {
        if (!count($params)) return '';

        $result = [];

        foreach ($params as $key => $item) {
            if ($item) {
                $result[] = $key.'='.$item;
            }
        }

        return join('&', $result);
    }

    public static function buildResponse(bool $status, $data = null, $error = [])
    {
        $result = [
            'status' => $status,
        ];

        if ($data) $result['data'] = $data;
        if (count($error) > 0) $result['error'] = $error;

        $resource = new BaseResponseResource($result);

        return $resource->resource;
    }
}
