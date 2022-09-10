<?php

namespace SSCache;

use Psr\SimpleCache\CacheInterface;

class CacheService extends AbstractCacheService implements CacheInterface
{
    public function get($key, $default = null): mixed
    {
        $this->validateKey($key);

        $item = $this->storage->read($key, $default);

        if ($item) {
            return $this->canSerialize ? \unserialize($item) : $item;
        }

        return $default;
    }

    public function getMultiple($keys, $default = null): iterable
    {
        if ($keys instanceof \Traversable) {
            $keys = \iterator_to_array($keys, false);
        }

        $this->validateKeys($keys);

        $items = $this->storage->read($keys, $default);

        foreach ($keys as $key) {
            if (!isset($items[$key]) || !$items[$key]) {
                $items[$key] = $default;

                continue;
            }

            if ($this->canSerialize) {
                $items[$key] =  \unserialize($items[$key]);
            }
        }

        return $items;
    }

    public function set($key, $value, $ttl = null)
    {
        $this->validateKey($key);

        $data = [$key => $value];

        $this->canSerialize && $this->serializeValues($data);

        return (bool) $this->storage->write($key, $data[$key], $ttl);
    }

    public function setMultiple($values, $ttl = null)
    {
        if ($values instanceof \Traversable) {
            $values = \iterator_to_array($values, true);
        }

        $this->validateKeys(\array_keys($values));

        $this->canSerialize && $this->serializeValues($values);

        return (bool) $this->storage->write(keys: $values, ttl: $ttl);
    }

    public function has($key)
    {
        $this->validateKey($key);

        return (bool) $this->storage->read($key);
    }

    public function delete($key)
    {
        $this->validateKey($key);

        return (bool) $this->storage->delete($key);
    }

    public function deleteMultiple($keys)
    {
        $this->validateKeys($keys);

        return (bool) $this->storage->delete($keys);
    }

    public function clear()
    {
        return $this->storage->clear();
    }
}
