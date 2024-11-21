<?php

namespace YG\ApiLibraryBase\Abstracts\Request;

use YG\ApiLibraryBase\Abstracts\Result\Result as ResultInterface;

interface RequestHandler
{
    public function handle(Request $request): ResultInterface;
}