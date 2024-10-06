<?php

namespace YG\ApiLibraryBase\Abstracts;

abstract class AbstractConfig implements Config
{
    private array $items = [];

    public function __construct(array $config)
    {
        $this->items = $config;
    }

    public function get(string $key): string
    {
        return $this->items[$key] ?? '';
    }

    private function set(string $key, string $value):void
    {
        $this->items[$key] = $value;
    }

    public function __call($name, $arguments)
    {
        if (count($arguments) === 0)
            return $this->get($name);

        $this->set($name, $arguments[0]);
        return $this;
    }
}