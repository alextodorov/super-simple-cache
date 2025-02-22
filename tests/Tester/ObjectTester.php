<?php

namespace SSCache\UnitTest\Tester;

class ObjectTester
{
    public function __construct(private string $test = 'new')
    {
    }

    public function __serialize(): array
    {
        return [
            'test' => $this->test,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->test = $data['test'];
    }

    public function getTest(): string
    {
        return $this->test;
    }
}
