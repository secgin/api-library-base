<?php

namespace YG\ApiLibraryBase\Abstracts\Config;

interface Config
{
    public function get(string $key): string;

    public function set(string $key, $value);
}