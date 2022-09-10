<?php

namespace SSCache;

use Closure;

abstract class AbstractCacheService
{
    protected bool $canSerialize = true;

    public function __construct(protected CacheStorageInterface $storage)
    {
    }

    public function validateKey(string $key): void
    {
        if (preg_match('/^[a-zA-Z0-9_.:]+$/', $key) !== 1) {
            throw new InvalidKey('Invalid Cache Key');
        }
    }

    public function validateKeys(iterable $keys): void
    {
        foreach ($keys as $key) {
            $this->validateKey($key);
        }
    }

    public function serializeValues(iterable &$values = []): void
    {
        foreach ($values as $key => $value) {
            if ($this->isInvalid($value)) {
                throw new InvalidArgument('Invalid value for key: ' . $key);
            }

            $values[$key] = \serialize($value);
        }
    }

    public function getWithClosure(string $key, Closure $closure): mixed
    {
        return $closure->call($this->storage, $key);
    }

    public function enableSerialization(): void
    {
        $this->canSerialize = true;
    }

    public function disableSerialization(): void
    {
        $this->canSerialize = false;
    }

    public function isInvalid(mixed $value): bool
    {
        if (\is_resource($value) || (\is_object($value) && !\method_exists($value, '__serialize'))) {
            return true;
        }

        return false;
    }
}
