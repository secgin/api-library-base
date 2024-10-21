<?php

namespace YG\ApiLibraryBase\Abstracts;

use Exception;

abstract class AbstractApiClient implements ApiClient
{
    private Config $config;

    private HttpClient $httpClient;

    protected TokenStorageService $tokenStorage;

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

    /**
     * @param $name
     * @return mixed|AbstractHandler|AbstractQueryHandler|AbstractCommandHandler
     */
    protected function getRequestHandler($name)
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

    protected function handle(string $requestName, $request): Result
    {
        $handler = $this->getRequestHandler($requestName);
        return $handler->handle($request);
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