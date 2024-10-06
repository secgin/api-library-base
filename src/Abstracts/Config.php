<?php

namespace YG\ApiLibraryBase\Abstracts;

interface Config
{
    public function get(string $key): string;
}