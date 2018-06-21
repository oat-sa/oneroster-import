<?php

namespace oat\OneRoster\Tests\Unit\Import;

use oat\OneRoster\File\FileHandler;
use oat\OneRoster\Import\ImporterFactory;
use oat\OneRoster\Import\ImporterInterface;
use PHPUnit\Framework\TestCase;

class ImporterFactoryTest extends TestCase
{
    public function testBuild()
    {
        $importerFactory = new ImporterFactory('v1.1',$this->mockFileHandler());

        $this->assertInstanceOf(ImporterInterface::class, $importerFactory->build('orgs'));
    }

    public function testBuildInvalid()
    {
        $this->expectException(\Exception::class);
        $importerFactory = new ImporterFactory('v1.1',$this->mockFileHandler());
        $importerFactory->build('invalid-type');
    }

    protected function mockFileHandler()
    {
        $file = $this->getMockBuilder(FileHandler::class)->disableOriginalConstructor()->getMock();

        $file
            ->method('getContents')
            ->willReturn(json_encode([]));

        return $file;
    }
}
