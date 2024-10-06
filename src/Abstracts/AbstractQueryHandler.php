<?php

namespace YG\ApiLibraryBase\Abstracts;

use YG\ApiLibraryBase\Abstracts\Result as ResultInterface;

abstract class AbstractQueryHandler extends AbstractHandler
{
    public abstract function handle(Query $query): ResultInterface;
}