<?php

declare(strict_types=1);

namespace SSCache;

use function unserialize;

class CacheSerializer extends AbstractCacheSerializer
{
    public function unserialize(string $item): mixed
    {
        return unserialize($item);
    }

    protected function getSerializeFunction(): string
    {
        return 'serialize';
    }
}
