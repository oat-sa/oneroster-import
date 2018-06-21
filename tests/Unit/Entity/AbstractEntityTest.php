<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use oat\OneRoster\Entity\AbstractEntity;
use PHPUnit\Framework\TestCase;

class AbstractEntityTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testGetData()
    {
        $stub = $this->getMockBuilder(AbstractEntity::class)->getMock();
        $stub
            ->method('getData')
            ->willReturn([]);

        $this->assertInternalType('array', $stub->getData());
    }

    public function testGetId()
    {
        $stub = $this->getMockBuilder(AbstractEntity::class)->getMock();
        $stub
            ->method('getId')
            ->willReturn('12345');

        $this->assertInternalType('string', $stub->getId());
    }
}
