<?php

namespace SSCache;

use DateInterval;

abstract class AbstractCacheService
{
    public function validateKey(string $key): bool
    {
        return true;
    }

    public function validateKeys(array $keys): bool
    {
        return true;
    }

    public function validateAndSerialize(array $data): bool
    {
        return true;
    }

    public function getWithClosure(string $key, callable $callback, DateInterval|int|null $ttl): mixed
    {
        return [];
    }
}
