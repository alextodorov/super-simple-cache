<?php

declare(strict_types=1);

namespace SSCache\UnitTest;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use SSCache\CacheKeyDelegator;
use SSCache\InvalidKey;

class CacheKeyDelegatorInvalidKeysTest extends TestCase
{
    #[DataProvider('invalidKeysData')]
    public function testInvalidKeyNames(string $key): void
    {
        /** @var CacheInterface */
        $cache = $this->createMock(CacheInterface::class);
        $delegator = new CacheKeyDelegator($cache);

        $this->expectException(InvalidKey::class);

        $delegator->validateKey($key);
    }

    public static function invalidKeysData(): array
    {
        return [
            ['test*'],
            ['+newKey+'],
            [':"key'],
            ['#1'],
            ['myKeu@'],
            ['!myKeuss'],
        ];
    }
}
