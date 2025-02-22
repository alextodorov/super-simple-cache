<?php

declare(strict_types=1);

namespace SSCache\UnitTest;

use SSCache\CacheKeyDelegator;
use SSCache\UnitTest\Tester\AbstractCacheDelegatorTester;

class CacheKeyDelegatorTest extends AbstractCacheDelegatorTester
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->delegator = new CacheKeyDelegator($this->cache);
    }
}
