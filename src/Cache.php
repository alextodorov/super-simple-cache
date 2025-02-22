<?php

declare(strict_types=1);

namespace SSCache;

use Psr\SimpleCache\CacheInterface;

final class Cache implements CacheInterface
{
    public function __construct(private CacheStorageInterface $storage)
    {
    }

    public function get($key, $default = null): mixed
    {
        $item = $this->storage->read($key);

        return $item ?: $default;
    }

    public function getMultiple($keys, $default = null): iterable
    {
        $items = $this->storage->read($keys);

        foreach ($keys as $key) {
            if (!isset($items[$key]) || !$items[$key]) {
                $items[$key] = $default;

                continue;
            }
        }

        return $items;
    }

    public function set($key, $value, $ttl = null)
    {
        return $this->storage->write($key, $value, $ttl);
    }

    public function setMultiple($values, $ttl = null)
    {
        return $this->storage->write(keys: $values, ttl: $ttl);
    }

    public function has($key)
    {
        return $this->storage->exist($key);
    }

    public function delete($key)
    {
        return $this->storage->delete($key);
    }

    public function deleteMultiple($keys)
    {
        return $this->storage->delete($keys);
    }

    public function clear()
    {
        return $this->storage->clear();
    }
}
