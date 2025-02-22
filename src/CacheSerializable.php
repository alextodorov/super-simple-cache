<?php

namespace SSCache;

interface CacheSerializable
{
    public function serialize(iterable &$values = []): void;
    public function unserialize(string $item): mixed;
    public function isValid(mixed $value): bool;
}
