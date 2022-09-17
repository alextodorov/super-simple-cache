<?php

namespace SSCache\UnitTest;

use PHPUnit\Framework\TestCase;
use SSCache\InvalidArgument;

class ObjectTraversableCacheTest extends TestCase
{
    use TestCacheHelper;

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

    public function testSetGetTraversable(): void
    {
        $data = [
            'key' => 'new',
            'key2' => 'new2',
            'key4' => 'new4',
        ];

        $object = new DummyData();
        $object->setData($data);

        $this->cacheService->setMultiple($object);
        $this->assertSame($data, $this->cacheService->getMultiple($object));

        $this->cacheService->set('test1', $object);
        $this->assertSame($data, $this->cacheService->get('test1'));
    }
}
