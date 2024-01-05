<?php

namespace App\Services\Curl;

use App\Services\BaseService;
use App\Utils\Helper;

class CurlService extends BaseService
{

    /**
     * @param string $baseUrl
     * @param string $method
     * @param array $header
     * @param array $params
     * @return void
     */
    public function request(string $baseUrl, string $method, array $params = [], array $header = [])
    {

        $curl = curl_init();
        $method = strtolower($method);
        $opt = array(
            'CURLOPT_URL' => $baseUrl,
            'CURLOPT_CONNECTTIMEOUT' => 3000,
            'CURLOPT_TIMEOUT' => 100,
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_HTTPHEADER' => [
                'Content-Type: application/json',
                ...$header
            ],
            'CURLOPT_SSL_VERIFYPEER' => false,
        );
        $queryStr = Helper::convertParamsToQueryString($params);
        $paramStr = $queryStr ? "?$queryStr" : $queryStr;

        switch ($method) {
            case 'get':
                $opt['CURLOPT_HTTPGET'] = true;
                if (count($params)) {
                    $opt['CURLOPT_URL'] = $baseUrl . $paramStr;
                }
                break;

            case 'post':
                $opt['CURLOPT_POST'] = true;
                $opt['CURLOPT_POSTFIELDS'] = $params;
                break;

            case 'delete':
                $opt['CURLOPT_CUSTOMREQUEST'] = 'DELETE';
                $opt['CURLOPT_URL'] = $baseUrl . $paramStr;
                break;

            default:
                break;
        }

        curl_setopt_array($curl, $opt);
    }
}
