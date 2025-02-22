<?php

namespace SSCache;

interface CacheKeyValidatable
{
    public function validateKey(string $key): void;
    public function validateKeys(iterable $keys): void;
}
