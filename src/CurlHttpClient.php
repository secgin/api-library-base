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

        $postFields = $this->isContentTypeUrlencoded($httpRequest)
            ? http_build_query($httpRequest->getData())
            : json_encode($httpRequest->getData(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

        $options = [
            CURLOPT_HTTPHEADER => $httpHeader,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_CUSTOMREQUEST => $httpRequest->getMethod(),
            CURLOPT_POSTFIELDS => $postFields
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

    private function isContentTypeUrlencoded(HttpRequest $httpRequest): bool
    {
        $headers = $httpRequest->getHeaders();
        $contentType = $headers['Content-Type'] ?? $headers['content-type'] ?? null;

        return $contentType == 'application/x-www-form-urlencoded';
    }
}