<?php

namespace SSCache\UnitTest;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class DummyData implements IteratorAggregate
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
