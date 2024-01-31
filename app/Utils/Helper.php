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
        $response = [];
    }

    public static function buildSuccessResponse($data = null, string $message = ''): array
    {
        return [
            'status' => true,
            'message' => $message,
            'data' => $data
        ];
    }

    public static function buildFailResponse(string $errorKey, ?string $message = ''): array
    {
        return [
            'status' => false,
            'message' => $message,
            'error' => [
                'errorKey' => $errorKey
            ]
        ];
    }

}
