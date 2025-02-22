<?php

declare(strict_types=1);

namespace SSCache\UnitTest\Tester;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use SSCache\AbstractCacheDelegator;

abstract class AbstractCacheDelegatorTester extends TestCase
{
    protected CacheInterface | MockObject $cache;
    protected AbstractCacheDelegator $delegator;

    protected function setUp(): void
    {
        $this->cache = $this->createMock(CacheInterface::class);
    }

    protected function mockCacheMethods(string $method, mixed $return = null): void
    {
        $mocker = $this->cache
            ->expects($this->once())
            ->method($method);

        if (is_null($return)) {
            $mocker
                ->willReturnArgument(0);

            return;
        }

        $mocker->willReturn($return);
    }

    public function testSet(): void
    {
        $this->mockCacheMethods('set', true);

        $this->assertTrue($this->delegator->set('test', 1));
    }

    public function testGet(): void
    {
        $this->mockCacheMethods('get');

        $this->assertSame('get', $this->delegator->get('get'));
    }

    public function testGetDefault(): void
    {
        $this->mockCacheMethods('get', 'default');

        $this->assertSame('default', $this->delegator->get('get', 'default'));
    }

    #[DataProvider('iterableDataSet')]
    public function testSetMultiple(iterable $value): void
    {
        $this->mockCacheMethods('setMultiple', true);

        $this->assertTrue($this->delegator->setMultiple($value));
    }

    public static function iterableDataSet(): array
    {
        $tester = new IterableDataTester();
        $tester->setData(['iterable' => 'iterable']);

        return [
            [
                ['iterable' => 1, 'iterable1' => 2],
            ],
            [
                $tester,
            ],
        ];
    }

    #[DataProvider('iterableDataGet')]
    public function testGetMultiple(array $expected, iterable $value): void
    {
        $this->mockCacheMethods('getMultiple', $expected);

        $this->assertSame($expected, $this->delegator->getMultiple($value));
    }

    public static function iterableDataGet(): array
    {
        $tester = new IterableDataTester();
        $tester->setData(['iterable' => 'iterable']);

        return [
            [
                ['iterable' => 'test', 'iterable1' => null], ['iterable', 'iterable1'],
            ],
            [
                ['iterable' => 'iterable'], $tester,
            ],
        ];
    }

    public function testHas(): void
    {
        $this->mockCacheMethods('has', true);

        $this->assertTrue($this->delegator->has('has'));
    }

    public function testHasNotExist(): void
    {
        $this->mockCacheMethods('has', false);

        $this->assertFalse($this->delegator->has('has'));
    }

    public function testDelete(): void
    {
        $this->mockCacheMethods('delete', true);

        $this->assertTrue($this->delegator->delete('delete'));
    }

    public function testDeleteMultiple(): void
    {
        $this->mockCacheMethods('deleteMultiple', true);

        $this->assertTrue($this->delegator->deleteMultiple(['delete']));
    }

    public function testClear(): void
    {
        $this->mockCacheMethods('clear', true);

        $this->assertTrue($this->delegator->clear('clear'));
    }
}
