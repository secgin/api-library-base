<?php

namespace YG\ApiLibraryBase\Abstracts;

interface HttpResult
{
    public function isSuccess(): bool;

    public function getErrorCode(): ?string;

    public function getErrorMessage(): ?string;

    public function getHttpCode(): int;

    /**
     * @return mixed
     */
    public function getData();
}