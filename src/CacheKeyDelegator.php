<?php

declare(strict_types=1);

namespace SSCache;

use Traversable;

use function preg_match;
use function iterator_to_array;
use function array_flip;
use function array_keys;

class CacheKeyDelegator extends AbstractCacheDelegator implements CacheKeyValidatable
{
    public const VALID_KEY_PATTERN = '/^[a-zA-Z0-9_.:]+$/';

    public function get($key, $default = null): mixed
    {
        $this->validateKey($key);

        return $this->cache->get($key, $default);
    }

    public function getMultiple($keys, $default = null): iterable
    {
        if ($keys instanceof Traversable) {
            $keys = array_flip(iterator_to_array($keys, true));
        }

        $this->validateKeys($keys);

        return $this->cache->getMultiple($keys, $default);
    }

    public function set($key, $value, $ttl = null)
    {
        $this->validateKey($key);

        return $this->cache->set($key, $value, $ttl);
    }

    public function setMultiple($values, $ttl = null)
    {
        if ($values instanceof Traversable) {
            $values = iterator_to_array($values, true);
        }

        $this->validateKeys(array_keys($values));

        return $this->cache->setMultiple($values, ttl: $ttl);
    }

    public function has($key)
    {
        $this->validateKey($key);

        return $this->cache->has($key);
    }

    public function delete($key)
    {
        $this->validateKey($key);

        return $this->cache->delete($key);
    }

    public function deleteMultiple($keys)
    {
        $this->validateKeys($keys);

        return $this->cache->deleteMultiple($keys);
    }

    public function validateKey(string $key): void
    {
        if (preg_match(self::VALID_KEY_PATTERN, $key) !== 1) {
            throw new InvalidKey('Invalid Cache Key');
        }
    }

    public function validateKeys(iterable $keys): void
    {
        foreach ($keys as $key) {
            $this->validateKey($key);
        }
    }
}
