<?php

namespace YG\ApiLibraryBase\Abstracts;

use Exception;

/**
 * @method static static create()
 */
abstract class AbstractCommand implements Command
{
    private array $data = [];

    public function getData(): array
    {
        return $this->data;
    }

    public function __call($name, $arguments)
    {
        if (isset($arguments[0]))
            $this->data[$name] = $arguments[0];

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