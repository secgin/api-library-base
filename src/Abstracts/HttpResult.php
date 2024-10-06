<?php

namespace YG\ApiLibraryBase\Abstracts;

interface HttpResult
{
    public function isSuccess(): bool;

    public function getErrorCode(): ?string;

    public function getErrorMessage(): ?string;

    /**
     * @return mixed
     */
    public function getData();
}