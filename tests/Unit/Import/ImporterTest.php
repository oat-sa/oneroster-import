<?php

namespace oat\OneRoster\Tests\Unit\Import;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Import\Importer;
use oat\OneRoster\Schema\UniqueEntityException;
use oat\OneRoster\Schema\Validator;
use PHPUnit\Framework\TestCase;

class ImporterTest extends TestCase
{
    public function testImportForSuccess(): void
    {
        $validatorMock = $this->createMock(Validator::class);
        $validatorMock->expects($this->once())
            ->method('validate')
            ->willReturn([
                'sourcedId' => '12345',
                'status' => 'active',
                'name' => 'my name'
            ]);

        $importer = new Importer($validatorMock);

        $header = ['sourcedId', 'status', 'name'];
        $data = [
            ['12345', 'active', 'my name']
        ];

        $result = $importer->import($header, $data);
        $this->assertTrue($result->containsKey('12345'));
    }


    public function testImportForUniqueEntityException(): void
    {
        $this->expectException(UniqueEntityException::class);
        $this->expectExceptionMessage('Entity with sourcedId 12345 already exist.');

        $validatorMock = $this->createMock(Validator::class);
        $validatorMock->expects($this->exactly(3))
            ->method('validate')
            ->willReturn(
                [
                    'sourcedId' => '12345',
                    'status' => 'active',
                    'name' => 'my name'
                ],
                [
                    'sourcedId' => '99999',
                    'status' => 'active9',
                    'name' => 'my name9'
                ],
                [
                    'sourcedId' => '12345',
                    'status' => 'active2',
                    'name' => 'my name2'
                ]
            );

        $importer = new Importer($validatorMock);

        $header = ['sourcedId', 'status', 'name'];
        $data = [
            ['12345', 'active', 'my name'],
            ['99999', 'active9', 'my name9'],
            ['12345', 'active2', 'my name2']
        ];

        $importer->import($header, $data);
    }
}
