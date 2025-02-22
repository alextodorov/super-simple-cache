<?php

namespace SSCache;

use SSCache\InvalidArgument;

use function is_resource;
use function is_object;
use function method_exists;

abstract class AbstractCacheSerializer implements CacheSerializable
{
    public function serialize(iterable &$values = []): void
    {
        foreach ($values as $key => $value) {
            if (!$this->isValid($value)) {
                throw new InvalidArgument('Invalid value for key: ' . $key);
            }

            $values[$key] = call_user_func($this->getSerializeFunction(), $value);
        }
    }

    public function isValid(mixed $value): bool
    {
        if (is_resource($value) || (is_object($value) && !method_exists($value, '__serialize'))) {
            return false;
        }

        return true;
    }

    abstract protected function getSerializeFunction(): string;
}
