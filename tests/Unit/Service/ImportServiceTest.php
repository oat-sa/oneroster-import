<?php

namespace oat\OneRoster\Tests\Service;

use oat\OneRoster\File\FileHandler;
use oat\OneRoster\Service\ImportService;
use PHPUnit\Framework\TestCase;

class ImportServiceTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testImportMultiple()
    {
        $service = new ImportService($this->mockFileHandler());

        $result = $service->importMultiple('/path/to/a/folder/');

        $this->assertInternalType('array', $result);
    }

    /**
     * @return FileHandler
     */
    protected function mockFileHandler()
    {
        $file = $this->getMockBuilder(FileHandler::class)->disableOriginalConstructor()->getMock();

        $file
            ->method('readCsvLine')
            ->willReturnOnConsecutiveCalls(
               ['header1', 'header2', 'header3', 'header4'], ['value1', 'value2', 'value3', 'value4']
            );
        $file
            ->method('getContents')
            ->willReturn(json_encode([]));

        return $file;
    }
}
