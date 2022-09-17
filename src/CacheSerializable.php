<?php

namespace SSCache;

interface CacheSerializable
{
    public function enableSerialization(): void;
    public function disableSerialization(): void;
    public function enableIgbinary(): void;
    public function disableIgbinary(): void;
    public function serializeValues(iterable &$values = []): void;
}
