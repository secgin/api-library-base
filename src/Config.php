<?php

namespace YG\ApiLibraryBase;

use YG\ApiLibraryBase\Abstracts\AbstractConfig;

/**
 * @method self baseUrl(string $baseUrl)
 */
final class Config extends AbstractConfig
{
    public static function create(array $config = []): self
    {
        return new self($config);
    }
}