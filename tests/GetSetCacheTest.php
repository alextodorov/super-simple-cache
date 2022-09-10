<?php

namespace SSCache\UnitTest;

use DateInterval;
use PHPUnit\Framework\TestCase;
use SSCache\InvalidKey;

class GetSetCacheTest extends TestCase
{
    use CacheHelper;

    /** @dataProvider provideData */
    public function testSetGet(string $key, mixed $value, DateInterval|int|null $ttl): void
    {
        $this->assertTrue($this->cacheService->set($key, $value, $ttl));
        $this->assertSame($value, $this->cacheService->get($key));
    }

    public function testGetNotExist(): void
    {
        $this->assertSame(0, $this->cacheService->get('not.exist', 0));
        $this->assertNull($this->cacheService->get('not.exist.2', null));
    }

    /** @dataProvider provideInvalidKeys */
    public function testSetInvalidKey(string $key): void
    {
        $this->expectException(InvalidKey::class);
        $this->cacheService->set($key, 'test', 100);
    }

    public function testEnableDisableSerialization(): void
    {
        $this->cacheService->disableSerialization();

        $this->cacheService->set('disableSerialization', 'test', 100);
        
        $this->assertSame('test', $this->cacheService->get('disableSerialization'));

        $this->cacheService->enableSerialization();
        $this->cacheService->set('enableSerialization', 'test2', 100);

        $this->assertSame('test2', $this->cacheService->get('enableSerialization'));
    }

    public function testSetGetMultiple(): void
    {
        $values = [
            'key1' => 2,
            'key2' => 5,
            'key3' => 3,
        ];

        $this->assertTrue($this->cacheService->setMultiple($values, 100));
        $this->assertSame(
            $values,
            $this->cacheService->getMultiple(\array_keys($values), 0)
        );
    }
    
    public function testGetWithClosure(): void
    {
        $this->cacheService->set('key', 'test4', 100);

        $this->assertSame('test4', $this->cacheService->getWithClosure('key', function ($key) {
            return \unserialize($this->read($key));
        }));
    }

    public function provideData(): array
    {
        return [
            [
                'key',
                'value',
                null,
            ],
            [
                'key2',
                34,
                100,
            ],
            [
                'key3',
                ['value'],
                new DateInterval('P1D'),
            ],
            [
                'key4',
                true,
                new DateInterval('PT10M'),
            ],
        ];
    }

    public function provideInvalidKeys(): array
    {
        return [
            [
                'test*',
            ],
            [
                '+newKey+',
            ],
            [
                ':"key',
            ],
            [
                '#1',
            ],
            [
                'myKeu@',
            ],
            [
                '!myKeuss',
            ],
        ];
    }
}
