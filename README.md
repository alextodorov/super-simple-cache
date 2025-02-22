# Super Simple Cache

A simple cache library implementing PSR-16.

![Build Status](https://github.com/alextodorov/super-simple-cache/actions/workflows/build.yml/badge.svg?branch=main) [![codecov](https://codecov.io/gh/alextodorov/super-simple-cache/branch/main/graph/badge.svg?token=AHKTD7FAQX)](https://codecov.io/gh/alextodorov/super-simple-cache)

Install
-------

```sh
composer require super-simple/cache
```

Requires PHP 8.4 or newer.

Usage
-----

Basic usage:

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use SSCache\Cache;

$cacheService = new Cache(new YourStorage());

// Adding a Serializer.
// The CacheSerializeDelegator uses default php serializer.
// For better performance could be added msgpack or igbinary.

$cacheSerializer = new CacheSerializeDelegator($cache);

// A CackeKeyDelegator must be the last one to handle key validation first

$cache = new CacheKeyDlelegator($cacheSerializer);


// Set the value
$cache->set($key, $value, $ttl);

// Get the value
$result = $cache->get($key);
```

The $ttl could be int, null or \DateInterval

The storage must implement SSCache\CacheStorageInterface.

It's up to you how to handle $ttl in the storage.

If better performance is need it then install extensions (msgpack or igbinary) and implement serialize functions.
A serializer must implement CacheSerializable or just extends the AbstractCacheSerializer. 

Extra behavior could be added using a Delegator which extends AbstractCacheDelegator.
