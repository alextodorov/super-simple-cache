<?php

namespace SSCache\UnitTest;

use PHPUnit\Framework\TestCase;
use SSCache\InvalidArgument;

class ObjectTraversableCacheTest extends TestCase
{
    use CacheHelper;

    public function testSetGetObject(): void
    {
        $value = new DummyObject();

        $this->assertTrue($this->cacheService->set('test', $value, 100));
        $result = $this->cacheService->get('test');

        $this->assertSame('new', $result->getTest());
    }

    public function testSetGetInvalidObject(): void
    {
        $value = new \stdClass();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Invalid value for key: test');

        $this->assertTrue($this->cacheService->set('test', $value, 100));
    }
}
