<?php

namespace YG\ApiLibraryBase\Abstracts;

use Exception;

/**
 * @method static static create()
 */
abstract class AbstractQuery implements Query
{
    private array $params = [];

    public function getParams(): array
    {
        return $this->params;
    }

    public function __call($name, $arguments)
    {
        if (isset($arguments[0]))
            $this->params[$name] = $arguments[0];

        return $this;
    }

    /**
     * @throws Exception
     */
    public static function __callStatic($name, $arguments)
    {
        if ($name == 'create')
            return new static();

        throw new Exception("Call to undefined method " . __CLASS__ . "::" . $name . "()");
    }
}