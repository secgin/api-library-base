<?php

namespace YG\ApiLibraryBase\Abstracts;

abstract class AbstractHandler
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
}