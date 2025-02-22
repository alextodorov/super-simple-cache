<?php

declare(strict_types=1);

namespace SSCache\UnitTest;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SSCache\CacheSerializable;
use SSCache\CacheSerializer;
use SSCache\InvalidArgument;
use SSCache\UnitTest\Tester\ObjectTester;
use stdClass;
use Throwable;

class CacheSerializerTest extends TestCase
{
    private CacheSerializable $serializer;

    protected function setUp(): void
    {
        $this->serializer = new CacheSerializer();
    }

    public function testSerializeUnserializeObject(): void
    {
        $object = new ObjectTester('test');
        $data = [$object];

        $this->serializer->serialize($data);

        $this->assertSame('test', ($this->serializer->unserialize($data[0]))->getTest());
    }

    #[DataProvider('serializeData')]
    public function testSerialize(array $expected, array $data): void
    {
        $this->serializer->serialize($data);

        $this->assertSame($expected, $data);
    }

    #[DataProvider('serializeData')]
    public function testUnserialize(array $data, array $expected): void
    {
        $this->assertSame($expected[0], $this->serializer->unserialize($data[0]));
    }

    public static function serializeData(): array
    {
        return [
            [['s:13:"Just a string";'], ['Just a string']],
            [['a:1:{i:0;s:22:"Just a string in array";}'], [['Just a string in array']]],
            [['i:45;'], [45]],
            [['d:2.2;'], [2.2]],
            [['b:1;'], [true]],
            [['b:0;'], [false]],
            [['N;'], [null]],
        ];
    }

    public function testSerializeNotSerializableObject(): void
    {
        $data = [new stdClass()];

        $this->expectException(InvalidArgument::class);

        $this->serializer->serialize($data);
    }

    public function testSerializeResource(): void
    {
        $resource = fopen(__DIR__ . '/test.txt', 'w+');
        $data = [$resource];

        try {
            $this->serializer->serialize($data);
        } catch (Throwable $throw) {
            unset($data);
            fclose($resource);
            unlink(__DIR__ . '/test.txt');

            $this->assertInstanceOf(InvalidArgument::class, $throw);
        }
    }
}
