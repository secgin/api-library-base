<?php

namespace YG\ApiLibraryBase\Abstracts\Request;

use YG\ApiLibraryBase\Abstracts\Config\Config;
use YG\ApiLibraryBase\Abstracts\Http\HttpClient;
use YG\ApiLibraryBase\Abstracts\Result\Result as ResultInterface;
use YG\ApiLibraryBase\Abstracts\TokenStorageService;

abstract class AbstractRequestHandler implements RequestHandler
{
    protected Config $config;

    protected HttpClient $httpClient;

    protected TokenStorageService $tokenStorageService;

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

    public abstract function handle(Request $request): ResultInterface;
}