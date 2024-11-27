<?php

namespace YG\ApiLibraryBase\Abstracts;

interface TokenStorageService
{
    public function hasToken(string $name): bool;

    public function getToken(string $name): string;

    public function setToken(string $name, string $token): void;
}