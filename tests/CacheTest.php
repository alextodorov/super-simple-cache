<?php

declare(strict_types=1);

namespace SSCache\UnitTest;

use DateInterval;
use PHPUnit\Framework\Attributes\DataProvider;
use SSCache\UnitTest\Tester\CacheTester;

use function array_keys;

class CacheTest extends CacheTester
{
    #[DataProvider('provideData')]
    public function testSetGetCache(string $key, mixed $value, DateInterval|int|null $ttl): void
    {
        $this->cache->set($key, $value, $ttl);

        $this->assertSame($value, $this->cache->get($key));
    }

    public static function provideData(): array
    {
        return [
            ['key', 'value', null],
            ['key2', 34, 100],
            ['key3', ['value'], new DateInterval('P1D')],
            ['key4', true, new DateInterval('PT10M')],
        ];
    }

    public function testGetNotExistDefault(): void
    {
        $this->assertSame(0, $this->cache->get('not.exist', 0));
    }

    public function testGetNotExistNull(): void
    {
        $this->assertNull($this->cache->get('not.exist'));
    }

    public function testSetGetMultiple(): void
    {
        $values = [
            'key1' => 2,
            'key2' => 5,
            'key3' => 3,
        ];

        $this->cache->setMultiple($values, 100);

        $values['test'] = 0;

        $this->assertSame(
            $values,
            $this->cache->getMultiple(array_keys($values), 0)
        );
    }

    public function testDelete(): void
    {
        $this->cache->set('test2', 5, 100);

        $this->cache->delete('test2');

        $this->assertNull($this->cache->get('test2'));
    }

    public function testDeleteMultiple(): void
    {
        $data = ['test11' => 41,'test22' => 51];

        $this->cache->setMultiple($data, 100);

        $this->cache->deleteMultiple(array_keys($data));

        $this->assertSame(
            [
                'test11' => -1,
                'test22' => -1,
            ],
            $this->cache->getMultiple(array_keys($data), -1)
        );
    }

    public function testHas(): void
    {
        $this->cache->setMultiple(['has1' => 'has', 'has2' => 'has'], 100);

        $this->assertTrue($this->cache->has('has2'));
    }

    public function testHasFalse(): void
    {
        $this->cache->set('has1', 'has', 100);

        $this->assertFalse($this->cache->has('has2'));
    }

    public function testClear(): void
    {
        $values = ['clear1' => 'clear2', 'clear2' => 'clear2'];

        $this->cache->setMultiple($values, 100);

        $this->cache->clear();

        $this->assertSame(
            [
                'clear1' => null,
                'clear2' => null,
            ],
            $this->cache->getMultiple(array_keys($values))
        );
    }
}
