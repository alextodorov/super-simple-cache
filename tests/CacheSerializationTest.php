<?php

namespace SSCache\UnitTest;

use PHPUnit\Framework\TestCase;

class CacheSerializationTest extends TestCase
{
    use TestCacheHelper;

    public function testEnableDisableSerialization(): void
    {
        $this->cacheService->disableSerialization();
        $this->cacheService->set('disableSerialization', 'test', 100);
        
        $this->assertSame('test', $this->cacheService->get('disableSerialization'));

        $this->cacheService->enableSerialization();
        $this->cacheService->set('enableSerialization', 'test2', 100);
        $this->cacheService->disableSerialization();

        $this->assertSame('test2', \unserialize($this->cacheService->get('enableSerialization')));
    }

    public function testEnableDisableIgbinsrySerialization(): void
    {
        $this->cacheService->enableIgbinary();

        $this->cacheService->set('igbinary', 'test', 100);
        $this->cacheService->disableSerialization();
        
        $this->assertSame('test', \igbinary_unserialize($this->cacheService->get('igbinary')));

        $this->cacheService->disableIgbinary();
        $this->cacheService->enableSerialization();

        $this->cacheService->set('serialize', 'test2', 100);


        $this->cacheService->disableSerialization();
        $this->assertSame('test2', \unserialize($this->cacheService->get('serialize')));
    }
}
