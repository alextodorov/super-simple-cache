<?php

namespace SSCache;

use Psr\SimpleCache\CacheInterface;

class CacheService extends AbstractCacheService implements CacheInterface, CacheSerializable
{
    use CacheSerialization;

    public function get($key, $default = null): mixed
    {
        $this->validateKey($key);

        $item = $this->storage->read($key, $default);

        if (!$item) {
            return $default;
        }

        if ($this->canSerialize) {
            return $this->isIgbinaryActive ? \igbinary_unserialize($item) : \unserialize($item);
        }

        return $item;
    }

    public function getMultiple($keys, $default = null): iterable
    {
        if ($keys instanceof \Traversable) {
            $keys = \array_flip(\iterator_to_array($keys, true));
        }

        $this->validateKeys($keys);

        $items = $this->storage->read($keys, $default);

        foreach ($keys as $key) {
            if (!isset($items[$key]) || !$items[$key]) {
                $items[$key] = $default;

                continue;
            }

            if ($this->canSerialize) {
                $items[$key] =
                    $this->isIgbinaryActive ? \igbinary_unserialize($items[$key]) : \unserialize($items[$key]);
            }
        }

        return $items;
    }

    public function set($key, $value, $ttl = null)
    {
        $this->validateKey($key);

        if ($value instanceof \Traversable) {
            $value = \iterator_to_array($value, true);
        }

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
