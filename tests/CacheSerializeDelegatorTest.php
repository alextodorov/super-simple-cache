<?php

declare(strict_types=1);

namespace SSCache\UnitTest;

use PHPUnit\Framework\MockObject\MockObject;
use SSCache\CacheSerializable;
use SSCache\CacheSerializeDelegator;
use SSCache\UnitTest\Tester\AbstractCacheDelegatorTester;
use SSCache\UnitTest\Tester\IterableDataTester;

class CacheSerializeDelegatorTest extends AbstractCacheDelegatorTester
{
    protected CacheSerializable | MockObject $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = $this->createMock(CacheSerializable::class);

        $this->delegator = new CacheSerializeDelegator($this->serializer, $this->cache);
    }

    protected function mockCacheMethods(string $method, mixed $return = null): void
    {
        if ($method === 'get' && $return != 'default') {
            $this->serializer
                ->expects($this->once())
                ->method('unserialize')
                ->willReturn($method);
        } elseif ($method === 'getMultiple') {
            $this->serializer
                ->expects($this->once())
                ->method('unserialize')
                ->willReturn($return['iterable']);
        } elseif ($method === 'set' || $method === 'setMultiple') {
            $this->serializer
                ->expects($this->once())
                ->method('serialize');
        }

        parent::mockCacheMethods($method, $return);
    }

    public function testSetIterable(): void
    {
        $tester = new IterableDataTester();
        $tester->setData(['iterable' => 'iterable']);

        $this->mockCacheMethods('set', true);

        $this->assertTrue($this->delegator->set('test', $tester));
    }
}
