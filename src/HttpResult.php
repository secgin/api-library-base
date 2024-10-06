<?php

namespace YG\ApiLibraryBase;

use YG\ApiLibraryBase;

final class HttpResult implements Abstracts\HttpResult
{
    private bool $success;

    private ?string $errorCode;

    private ?string $errorMessage;

    /**
     * @var mixed
     */
    private $data;

    private function __construct()
    {
        $this->data = null;
        $this->errorCode = null;
        $this->errorMessage = null;
    }

    public static function success(?string $rawResult = null): HttpResult
    {
        $result = new self();
        $result->success = true;
        $result->data = empty($rawResult)
            ? null
            : json_decode($rawResult);
        return $result;
    }

    public static function fail(string $errorCode, string $errorMessage): HttpResult
    {
        $result = new self();
        $result->success = false;
        $result->errorCode = $errorCode;
        $result->errorMessage = $errorMessage;
        return $result;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function getData()
    {
        return $this->data;
    }
}