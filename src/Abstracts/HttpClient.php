<?php

namespace YG\ApiLibraryBase\Abstracts;

interface HttpClient
{
    public function send(HttpRequest $httpRequest): HttpResult;
}