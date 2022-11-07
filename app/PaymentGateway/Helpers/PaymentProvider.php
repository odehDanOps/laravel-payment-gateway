<?php

namespace App\PaymentGateway\Helpers;

use Illuminate\Support\Facades\Log;

class PaymentProvider
{
    /**
     * Set GET request headers
     *
     * @return Array []
     */
    public static function setGetHeaders($key)
    {
        $headers = [
            'Authorization: Bearer ' .$key['secret_key']
        ];
        return $headers;
    }


     /**
     * Set POST request headers
     *
     * @return Array []
     */
    public static function setPostHeaders($key, $contentLength)
    {
        $headers = [
            'Content-Type: application/json',
            'Content-Length: ' . $contentLength,
            'Accept: application/json',
            'Authorization: Bearer ' .$key['secret_key']
        ];
        return $headers;
    }


    /**
     * CURL API.
     *
     * @param $method
     * @param $url
     * @param Array $data
     * @param Array $key
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public static function curlAPI($method, $url, $data = null, $key)
    {
        $contentLength = 0;
        $requestJson = "";
        if (!empty($data)) {
            $requestJson = json_encode($data);
            $contentLength = isset($requestJson) ? strlen($requestJson) : 0;
        }
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $requestJson);
                }
                $headers = self::setPostHeaders($key, $contentLength);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                $headers = self::setPostHeaders($key, $contentLength);
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                $headers = self::setPostHeaders($key, $contentLength);
                break;

            default:
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
                $headers = self::setGetHeaders($key);
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_ENCODING , "");
        curl_setopt($curl, CURLOPT_MAXREDIRS , 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $rawResponse = curl_exec($curl);

        $response = json_decode($rawResponse);

        if (!$rawResponse) {
            die("Connection Failure");
        }
        curl_close($curl);

        return $response;
    }

}
