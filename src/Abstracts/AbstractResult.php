<?php

namespace YG\ApiLibraryBase\Abstracts;

abstract class AbstractResult implements Result
{
    private bool $success;

    private ?string $message;

    /**
     * @var array|mixed
     */
    protected $data;

    public function __construct(HttpResult $httpResult)
    {
        $this->success = $httpResult->isSuccess();
        $this->message = $httpResult->getErrorMessage();
        $this->data = null;

        if ($httpResult->isSuccess())
        {
            $data = $httpResult->getData();
            $status = $data->status ?? 'fail';

            $this->success = $status == 'success';
            $this->message = $data->message ?? null;
            $this->data = $data->data ?? null;
        }
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message ?? '';
    }

    public function __get($name)
    {
        if (isset($this->data->{$name}))
            return $this->data->{$name};

        return null;
    }
}