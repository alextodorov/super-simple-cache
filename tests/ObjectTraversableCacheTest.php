<?php

declare(strict_types=1);

namespace SSCache\UnitTest;

use SSCache\UnitTest\Tester\CacheTester;
use SSCache\UnitTest\Tester\IterableDataTester;

class ObjectTraversableCacheTest extends CacheTester
{
    private IterableDataTester $traversable;

    protected function setUp(): void
    {
        $data = [
            'key' => 'new',
            'key2' => 'new2',
            'key4' => 'new4',
        ];

        $this->traversable = new IterableDataTester();
        $this->traversable->setData($data);

        parent::setUp();
    }

    public function testTraversable(): void
    {
        $this->cache->set('test1', $this->traversable);

        $this->assertSame($this->traversable, $this->cache->get('test1'));
    }

    public function testTraversableMulti(): void
    {
        $this->cache->setMultiple($this->traversable);

        $this->assertSame(
            $this->traversable->getData(),
            $this->cache->getMultiple(
                array_keys(iterator_to_array($this->traversable))
            )
        );
    }
}
