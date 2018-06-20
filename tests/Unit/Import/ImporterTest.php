<?php

namespace oat\OneRoster\Tests\Import;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Import\Importer;
use oat\OneRoster\Schema\Validator;
use PHPUnit\Framework\TestCase;

class ImporterTest extends TestCase
{
    public function testImport()
    {
        $importer = new Importer($this->mockSchema());

        $result = $importer->import(['sourcedId', 'status', 'name'], [ ['12345', 'active', 'my name'] ]);

        $this->assertInstanceOf(ArrayCollection::class, $result);
    }

    protected function mockSchema()
    {
        $schema = $this->getMockBuilder(Validator::class)->disableOriginalConstructor()->getMock();

        $schema
            ->method('validate')
            ->willReturn([
                'sourcedId' => '12345',
                'status' => 'active',
                'name' => 'my name'
            ]);
        return $schema;
    }
}
