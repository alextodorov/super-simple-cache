<?php

declare(strict_types=1);

namespace SSCache\UnitTest\Tester;

use PHPUnit\Framework\TestCase;
use SSCache\Cache;
use SSCache\UnitTest\Tester\TestArrayStorageTester;

class CacheTester extends TestCase
{
    protected Cache $cache;

    protected function setUp(): void
    {
        $this->cache = new Cache(new TestArrayStorageTester());
    }
}
