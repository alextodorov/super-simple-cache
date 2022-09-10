<?php

namespace SSCache\UnitTest;

use SSCache\CacheStorageInterface;

class ArrayStorageHelper implements CacheStorageInterface
{
    private array $cache = [];

    public function read(string|iterable $key): mixed
    {
        if (\is_string($key)) {
            return $this->cache[$key] ?? false;
        }

        $items = [];
        foreach ($key as $search) {
            $items[$search] = $this->cache[$search] ?? false;
        }

        return $items;
    }

    public function write(string|iterable $keys, mixed $value = null, \DateInterval | int | null $ttl = null): bool
    {
        if (\is_string($keys)) {
            $this->cache[$keys] = $value;

            return true;
        }

        foreach ($keys as $name => $value) {
            $this->cache[$name] = $value;
        }

        return true;
    }

    public function delete(string|iterable $keys): bool
    {
        if (\is_string($keys)) {
            unset($this->cache[$keys]);

            return true;
        }

        foreach ($keys as $key) {
            unset($this->cache[$key]);
        }

        return true;
    }

    public function clear(): bool
    {
        unset($this->cache);
        return true;
    }

    public function exist(string $key): bool
    {
        return isset($this->cache['key']);
    }
}
