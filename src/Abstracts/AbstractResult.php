<?php

namespace YG\ApiLibraryBase\Abstracts;

abstract class AbstractResult implements Result
{
    private bool $success;

    private ?string $errorCode;

    private ?string $errorMessage;

    /**
     * @var array|mixed
     */
    protected $data;

    public function __construct(HttpResult $httpResult)
    {
        $this->success = $httpResult->isSuccess();
        $this->errorMessage = $httpResult->getErrorMessage();
        $this->data = null;

        if ($httpResult->isSuccess())
        {
            if ($httpResult->getHttpCode() == 401)
            {
                $this->success = false;
                $this->errorCode = 'UNAUTHORIZED';
                $this->errorMessage = 'You are not authorized to access this resource.';
            }
            else
            {
                $data = $httpResult->getData();
                $status = $data->status ?? 'fail';

                $this->success = $status == 'success';
                $this->errorMessage = $data->message ?? null;
                $this->data = $data->data ?? null;
            }
        }
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode ?? '';
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage ?? '';
    }

    public function __get($name)
    {
        if (isset($this->data->{$name}))
            return $this->data->{$name};

        return null;
    }
}