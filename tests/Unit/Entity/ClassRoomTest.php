<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\ClassRoom;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class ClassRoomTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testGetOrgs()
    {
        $entity = $this->getEntity('schoolSourcedId');

        $this->assertInstanceOf(ArrayCollection::class, $entity->getOrgs());
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetAcademicSessions()
    {
        $entity = $this->getEntity('termSourcedId');

        $this->assertInstanceOf(ArrayCollection::class, $entity->getOrgs());
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetEnrollments()
    {
        $entity = $this->getEntity('sourcedId');

        $this->assertInstanceOf(ArrayCollection::class, $entity->getEnrollments());
    }

    public function testGetType()
    {
        $this->assertEquals('classes', ClassRoom::getType());
    }

    /**
     * @throws \ReflectionException
     */
    protected function getEntity($index)
    {
        $obj = new ClassRoom();
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
                    'classes' => [
                        'sourcedId' => '12345',
                        'schoolSourcedId' => 'school_id',
                        'classSourcedId' => 'class_id',
                        'termSourcedId' => 'academic_id'
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
