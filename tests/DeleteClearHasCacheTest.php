<?php

namespace SSCache\UnitTest;

use PHPUnit\Framework\TestCase;

class DeleteClearHasCacheTest extends TestCase
{
    use CacheHelper;

    public function testDelete(): void
    {
        $this->cacheService->setMultiple(['test1' => 4, 'test2' => 5], 100);
    
        $this->assertTrue($this->cacheService->delete('test1'));
        $this->assertTrue($this->cacheService->delete('test2'));

        $this->assertNull($this->cacheService->get('test1', null));
    }

    public function testDeleteMultiple(): void
    {
        $values = [
            'test11' => 41,
            'test22' => 51,
        ];

        $this->cacheService->setMultiple($values, 100);
    
        $this->assertTrue($this->cacheService->deleteMultiple(\array_keys($values)));

        $this->assertSame(
            [
                'test11' => -1,
                'test22' => -1,
            ],
            $this->cacheService->getMultiple(\array_keys($values), -1)
        );
    }

    public function testHas(): void
    {
        $this->cacheService->setMultiple(['has1' => 'has', 'has2' => 'has'], 100);
    
        $this->assertTrue($this->cacheService->has('has2'));
        $this->assertTrue($this->cacheService->has('has1'));
        $this->assertFalse($this->cacheService->has('has3'));
    }

    public function testClear(): void
    {
        $this->cacheService->setMultiple(['has1' => 'has', 'has2' => 'has'], 100);
    
        $this->assertTrue($this->cacheService->clear());
        $this->assertFalse($this->cacheService->has('has1'));
        $this->assertFalse($this->cacheService->has('has2'));
    }
}
