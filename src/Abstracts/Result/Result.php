<?php

namespace YG\ApiLibraryBase\Abstracts\Result;

interface Result
{
    public function isSuccess(): bool;

    public function getErrorCode(): string;

    public function getErrorMessage(): string;
}