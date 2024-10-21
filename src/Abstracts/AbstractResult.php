<?php

namespace YG\ApiLibraryBase\Abstracts;

use Exception;

/**
 * @method static static create(HttpResult $httpResult)
 */
abstract class AbstractResult implements Result
{
    public function __construct(HttpResult $httpResult)
    {
    }

    public function __get($name)
    {
        if (isset($this->data->{$name}))
            return $this->data->{$name};

        return null;
    }

    /**
     * @throws Exception
     */
    public static function __callStatic($name, $arguments)
    {
        if ($name == 'create' and isset($arguments[0]) and $arguments[0] instanceof HttpResult)
            return new static(...$arguments);

        throw new Exception("Call to undefined method " . __CLASS__ . "::" . $name . "()");
    }
}