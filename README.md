# Super Simple Cache

A simple cache library implementing PSR-16.

![Build Status](https://github.com/alextodorov/super-simple-cache/actions/workflows/build.yml/badge.svg?branch=main) [![codecov](https://codecov.io/gh/alextodorov/super-simple-cache/branch/main/graph/badge.svg?token=AHKTD7FAQX)](https://codecov.io/gh/alextodorov/super-simple-cache) [![Latest Stable Version](http://poser.pugx.org/super-simple/cache/v)](https://packagist.org/packages/super-simple/cache) [![PHP Version Require](http://poser.pugx.org/super-simple/cache/require/php)](https://packagist.org/packages/super-simple/cache) [![License](http://poser.pugx.org/super-simple/cache/license)](https://packagist.org/packages/super-simple/cache) [![Total Downloads](http://poser.pugx.org/super-simple/cache/downloads)](https://packagist.org/packages/super-simple/cache)

Install
-------

```sh
composer require super-simple/cache
```

Requires PHP 8.1 or newer.

Usage
-----

Basic usage:

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use SSCache\CacheService;

$cache = (new CacheService(new YourStorage()));

// Set the value
$cache->set($key, $value, $ttl);

// Get the value
$result = $cache->get($key);
```

The $ttl could be int, null or \DateInterval

The storage must implement SSCache\CacheStorageInterface.

It's up to you how to handle $ttl in the storage.

For more details check out the [wiki].

[wiki]: https://github.com/alextodorov/super-simple-cache/wiki


License
-----

The Super Simple Cache is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).