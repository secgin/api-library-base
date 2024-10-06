<?php

namespace YG\ApiLibraryBase;

final class TokenStorageService implements Abstracts\TokenStorageService
{
    public function hasToken(): bool
    {
        return isset($_SESSION['userToken']);
    }

    public function getToken(): string
    {
        return $this->hasToken()
            ? $_SESSION['userToken']
            : '';
    }

    public function setToken(string $token): void
    {
         $_SESSION['userToken'] = $token;
    }
}