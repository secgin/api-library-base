<?php

namespace YG\ApiLibraryBase\Abstracts;

use Exception;

abstract class AbstractApiClient implements ApiClient
{
    private Config $config;

    private HttpClient $httpClient;

    private TokenStorageService $tokenStorage;

    private array $requestHandlerClasses = [];

    public function __construct(Config $config, HttpClient $httpClient, TokenStorageService $tokenStorage)
    {
        $this->config = $config;
        $this->httpClient = $httpClient;
        $this->tokenStorage = $tokenStorage;
        $this->requestHandlerClasses = $this->getRequestHandlerClasses();
    }

    protected abstract function getRequestHandlerClasses(): array;

    private function hasRequestHandlerClass(string $name): bool
    {
        return isset($this->requestHandlerClasses[$name]);
    }

    private function getRequestHandler($name)
    {
        $requestHandlerClass = $this->requestHandlerClasses[$name];
        $handler = new $requestHandlerClass();
        if ($handler instanceof AbstractHandler)
        {
            $handler->setConfig($this->config);
            $handler->setHttpClient($this->httpClient);
            $handler->setTokenStorageService($this->tokenStorage);
        }
        return $handler;
    }

    private function handle(string $requestName, $request): Result
    {
        $result = $this->getRequestHandler($requestName)->handle($request);

        if ($result->getErrorCode() == 'UNAUTHORIZED')
        {
            $this->refreshToken();
            $result = $this->getRequestHandler($requestName)->handle($request);
        }

        return $result;
    }

    private function refreshToken(): void
    {
        $result = $this->getRequestHandler('getToken')->handle();
        if ($result->isSuccess())
            $this->tokenStorage->setToken($result->token);
    }

    #region Magic Methods
    /**
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        if ($this->hasRequestHandlerClass($name))
            return $this->handle($name, $arguments[0] ?? null);

        throw new Exception('Method not found');
    }
    #endregion
}