<?php

namespace SSCache;

interface CacheStorageInterface
{
    public function read(string|iterable $keys): mixed;
    public function write(string|iterable $keys, mixed $value = null, \DateInterval | int | null $ttl = null): bool;
    public function delete(string|iterable $keys): bool;
    public function clear(): bool;
    public function exist(string $key): bool;
}
