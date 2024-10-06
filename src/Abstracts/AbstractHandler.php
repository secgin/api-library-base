<?php

namespace YG\ApiLibraryBase\Abstracts;

use YG\ApiLibraryBase\Abstracts\Result as ResultInterface;
use YG\ApiLibraryBase\Result;

abstract class AbstractHandler
{
    protected Config $config;

    protected HttpClient $httpClient;

    protected TokenStorageService $tokenStorageService;

    protected function sendRequest(HttpRequest $httpRequest): ResultInterface
    {
        return new Result($this->httpClient->send($httpRequest));
    }

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    public function setHttpClient(HttpClient $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    public function setTokenStorageService(TokenStorageService $tokenStorageService): void
    {
        $this->tokenStorageService = $tokenStorageService;
    }
}