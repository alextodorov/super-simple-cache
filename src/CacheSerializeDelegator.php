<?php

declare(strict_types=1);

namespace SSCache;

use Psr\SimpleCache\CacheInterface;
use Traversable;

use function iterator_to_array;

class CacheSerializeDelegator extends AbstractCacheDelegator
{
    public function __construct(private CacheSerializable $serializer, CacheInterface $cache)
    {
        parent::__construct($cache);
    }

    public function get($key, $default = null): mixed
    {
        $item = $this->cache->get($key, $default);

        if ($item === $default) {
            return $item;
        }

        return $this->serializer->unserialize($item);
    }

    public function getMultiple($keys, $default = null): iterable
    {
        $items = $this->cache->getMultiple($keys, $default);

        foreach ($keys as $key) {
            if ($items[$key] === $default) {
                continue;
            }

            $items[$key] = $this->serializer->unserialize($items[$key]);
        }

        return $items;
    }

    public function set($key, $value, $ttl = null)
    {
        if ($value instanceof Traversable) {
            $value = iterator_to_array($value, true);
        }

        $data = [$key => $value];

        $this->serializer->serialize($data);

        return $this->cache->set($key, $data[$key], $ttl);
    }

    public function setMultiple($values, $ttl = null)
    {
        $this->serializer->serialize($values);

        return $this->cache->setMultiple($values, ttl: $ttl);
    }
}
