<?php

declare(strict_types=1);

namespace SSCache;

use Psr\SimpleCache\CacheInterface;

abstract class AbstractCacheDelegator implements CacheInterface
{
    public function __construct(protected CacheInterface $cache)
    {
    }

    public function has($key)
    {
        return $this->cache->has($key);
    }

    public function delete($key)
    {
        return $this->cache->delete($key);
    }

    public function deleteMultiple($keys)
    {
        return $this->cache->deleteMultiple($keys);
    }

    public function clear()
    {
        return $this->cache->clear();
    }
}
