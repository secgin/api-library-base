<?php

namespace YG\ApiLibraryBase\Abstracts;

interface Config
{
    public function get(string $key): string;

    public function set(string $key, $value);
}