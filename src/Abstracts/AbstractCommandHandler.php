<?php

namespace YG\ApiLibraryBase\Abstracts;

use YG\ApiLibraryBase\Abstracts\Result as ResultInterface;

abstract class AbstractCommandHandler extends AbstractHandler
{
    public abstract function handle(?Command $command): ResultInterface;
}