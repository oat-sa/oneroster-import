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
        $file = $this->getMockBuilder(FileHandler::class)->disableOriginalConstructor()->getMock();

        $file
            ->method('readCsvLine')
            ->willReturnOnConsecutiveCalls(
                ['propertyName', 'value'],['file.orgs','bulk'], false, ['header1', 'header2', 'header3', 'header4'], ['value1', 'value2', 'value3', 'value4']
            );
        $file
            ->method('getContents')
            ->willReturn(json_encode([]));

        $service = new ImportService($file);

        $result = $service->importMultiple('/path/to/a/folder/');

        $this->assertInternalType('array', $result);
    }
}
