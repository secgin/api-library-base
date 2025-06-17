<?php

namespace YG\ApiLibraryBase\Abstracts\Services;

use DateTimeInterface;

interface AccessToken
{
    public function getToken(): string;

    public function getExpirationAt(): DateTimeInterface;

    public function isExpirationPassed(): bool;
}