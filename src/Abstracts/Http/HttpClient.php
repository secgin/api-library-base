<?php

namespace YG\ApiLibraryBase\Abstracts\Http;

interface HttpClient
{
    public function send(HttpRequest $httpRequest): HttpResult;
}