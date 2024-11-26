<?php

namespace YG\ApiLibraryBase\Abstracts;

use Exception;
use YG\ApiLibraryBase\Abstracts\Config\Config;
use YG\ApiLibraryBase\Abstracts\Http\HttpClient;
use YG\ApiLibraryBase\Abstracts\Request\AbstractRequestHandler;
use YG\ApiLibraryBase\Abstracts\Result\Result;
use YG\ApiLibraryBase\CurlHttpClient;

/**
 * @property-read HttpClient $httpClient
 */
abstract class AbstractApiClient implements ApiClient
{
    private Config $config;

    private HttpClient $httpClient;

    protected ?TokenStorageService $tokenStorage;

    private array $requestHandlerClasses = [];

    public function __construct(Config $config, HttpClient $httpClient = null)
    {
        $this->config = $config;
        $this->httpClient = $httpClient ?? new CurlHttpClient();
        $this->tokenStorage = null;
        $this->requestHandlerClasses = $this->getRequestHandlerClasses();
    }

    public function setTokenStorage(TokenStorageService $tokenStorage): void
    {
        $this->tokenStorage = $tokenStorage;
    }

    protected abstract function getRequestHandlerClasses(): array;

    private function hasRequestHandlerClass(string $name): bool
    {
        return isset($this->requestHandlerClasses[$name]);
    }

    /**
     * @param $name
     *
     * @return mixed|AbstractRequestHandler
     */
    protected function getRequestHandler($name)
    {
        $requestHandlerClass = $this->requestHandlerClasses[$name];
        $handler = new $requestHandlerClass();
        if ($handler instanceof AbstractRequestHandler)
        {
            $handler->setConfig($this->config);
            $handler->setHttpClient($this->httpClient);

            if ($this->tokenStorage != null)
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
    public function __get($name)
    {
        if ($name == 'httpClient')
            return $this->httpClient;

        throw new Exception('Undefined property via __get()');
    }

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