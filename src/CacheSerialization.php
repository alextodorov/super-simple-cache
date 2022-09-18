<?php

namespace SSCache;

use SSCache\InvalidArgument;

trait CacheSerialization
{
    protected bool $canSerialize = true;
    protected bool $isIgbinaryActive = false;

    public function enableSerialization(): void
    {
        $this->canSerialize = true;
    }

    public function disableSerialization(): void
    {
        $this->canSerialize = false;
    }

    public function enableIgbinary(): void
    {
        $this->isIgbinaryActive = true;
    }

    public function disableIgbinary(): void
    {
        $this->isIgbinaryActive = false;
    }

    public function serializeValues(iterable &$values = []): void
    {
        $serialize = $this->isIgbinaryActive ? \igbinary_serialize(...) : \serialize(...);

        foreach ($values as $key => $value) {
            if ($this->isInvalid($value)) {
                throw new InvalidArgument('Invalid value for key: ' . $key);
            }


            $values[$key] = $serialize($value);
        }
    }
}
