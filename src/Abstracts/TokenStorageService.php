<?php

namespace YG\ApiLibraryBase\Abstracts;

interface TokenStorageService
{
    public function hasToken(): bool;

    public function getToken(): string;

    public function setToken(string $token): void;
}