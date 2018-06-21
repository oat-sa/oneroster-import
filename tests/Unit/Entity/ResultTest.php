<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\LineItem;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Entity\Result;
use oat\OneRoster\Entity\User;
use oat\OneRoster\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{

    public function testGetLineItem()
    {
        $entity = $this->getEntity('lineItemSourcedId');

        $this->assertInstanceOf(LineItem::class, $entity->getLineItem());
    }

    public function testGetUser()
    {
        $entity = $this->getEntity('studentSourcedId');

        $this->assertInstanceOf(User::class, $entity->getUser());
    }

    public function testGetType()
    {
        $this->assertSame('results', Result::getType());
    }

    /**
     * @throws \ReflectionException
     */
    protected function getEntity($index)
    {
        $obj = new Result();
        $obj->setId('class1');
        $obj->setStorage($this->mockStorage());
        $obj->setRelationConfig($this->mockRelationConfig($index));

        return $obj;
    }

    /**
     * @return StorageInterface
     * @throws \ReflectionException
     */
    protected function mockStorage()
    {
        $storage = $this->getMockForAbstractClass(StorageInterface::class);

        $storage
            ->method('findByType')
            ->willReturn(new ArrayCollection([
                    'orgs' => [
                        'sourcedId' => 'school_id'
                    ],
                    'enrollments' => [
                        'sourcedId' => 'class_id'
                    ],
                ])
            );

        $storage
            ->method('findByTypeAndId')
            ->willReturn(new ArrayCollection([
                    'courseResources' => [
                        'sourcedId' => '12345',
                        'lineItemSourcedId' => 'line_item_id',
                        'studentSourcedId' => 'student_source_id',
                    ],
                ])
            );

        return $storage;
    }

    /**
     * @return RelationConfig
     */
    protected function mockRelationConfig($index)
    {
        $relation = $this->getMockBuilder(RelationConfig::class)->disableOriginalConstructor()->getMock();

        $relation
            ->method('getConfig')
            ->willReturn($index);

        return $relation;
    }
}
