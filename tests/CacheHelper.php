<?php

namespace SSCache\UnitTest;

use SSCache\CacheService;

trait CacheHelper
{
    protected CacheService $cacheService;

    protected function setUp(): void
    {
        $this->cacheService = new CacheService(new ArrayStorageHelper());   
    }
}
