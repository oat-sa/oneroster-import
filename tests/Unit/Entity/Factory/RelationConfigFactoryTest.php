<?php

namespace oat\OneRoster\Tests\Unit\Entity\Factory;

use oat\OneRoster\Entity\Factory\RelationConfigFactory;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\File\FileHandler;
use PHPUnit\Framework\TestCase;

class RelationConfigFactoryTest extends TestCase
{
    public function testCreate()
    {
        $file = $this->getMockBuilder(FileHandler::class)->disableOriginalConstructor()->getMock();
        $file
            ->method('getContents')
            ->willReturn(json_encode([]));

        $factory = new RelationConfigFactory($file);

        $this->assertInstanceOf(RelationConfig::class, $factory->create());
    }
}
