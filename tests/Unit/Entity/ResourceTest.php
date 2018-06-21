<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use oat\OneRoster\Entity\Resource;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    public function testGetType()
    {
        $this->assertSame('resources', Resource::getType());
    }
}
