<?php

namespace YG\ApiLibraryBase\Abstracts;

interface Result
{
    public function isSuccess(): bool;

    public function getMessage(): string;
}