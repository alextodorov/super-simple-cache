<?php

namespace SSCache\UnitTest\Tester;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class IterableDataTester implements IteratorAggregate
{
    private $data = [];

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }
}
