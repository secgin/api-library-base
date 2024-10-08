<?php

namespace YG\ApiLibraryBase;

use YG\ApiLibraryBase\Abstracts\HttpRequest;

final class CurlHttpClient implements Abstracts\HttpClient
{
    private ?string $baseUrl;

    public function __construct(?string $baseUrl = null)
    {
        $this->baseUrl = $baseUrl;
    }

    public function send(HttpRequest $httpRequest): HttpResult
    {
        $httpHeader = array_map(function ($key, $value)
        {
            return $key . ': ' . $value;
        }, array_keys($httpRequest->getHeaders()), $httpRequest->getHeaders());

        $options = [
            CURLOPT_HTTPHEADER => $httpHeader,
            CURLOPT_HEADER => 0,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_DEFAULT,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_CUSTOMREQUEST => $httpRequest->getMethod(),
            CURLOPT_POSTFIELDS => json_encode($httpRequest->getData())
        ];

        $url = $this->baseUrl . $httpRequest->getUrl();
        if (!empty($httpRequest->getQueryParams()))
            $url .= '?' . http_build_query($httpRequest->getQueryParams());

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        $requestResult = $result === false
            ? HttpResult::fail($httpCode, curl_errno($ch), curl_error($ch))
            : HttpResult::success($httpCode, $result);

        curl_close($ch);
        return $requestResult;
    }
}