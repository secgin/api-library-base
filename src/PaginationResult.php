<?php

namespace YG\ApiLibraryBase;

use YG\ApiLibraryBase\Abstracts\AbstractResult;

final class PaginationResult extends AbstractResult
{
    public function __get($name)
    {
        if ($name == 'totalItems')
            return $this->data['total_items'] ?? 0;

        return parent::__get($name);
    }
}