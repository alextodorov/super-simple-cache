<?php

namespace SSCache\UnitTest;

use SSCache\CacheService;

trait TestCacheHelper
{
    protected CacheService $cacheService;

    protected function setUp(): void
    {
        $this->cacheService = new CacheService(new TestArrayStorageHelper());
    }
}
