<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\Enrollment;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class EnrollmentTest extends TestCase
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
    public function testGetClasses()
    {
        $entity = $this->getEntity('classSourcedId');

        $this->assertInstanceOf(ArrayCollection::class, $entity->getClasses());
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetUsers()
    {
        $entity = $this->getEntity('userSourcedId');

        $this->assertInstanceOf(ArrayCollection::class, $entity->getUsers());
    }

    public function testGetType()
    {
        $this->assertEquals('enrollments', Enrollment::getType());
    }

    /**
     * @throws \ReflectionException
     */
    protected function getEntity($index)
    {
        $obj = new Enrollment();
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
                        'sourcedId' => 'enrollment_id'
                    ],
                    'users' => [
                        'sourcedId' => 'user_id'
                    ],
                    'classes' => [
                        'sourcedId' => 'class_id'
                    ],
                ])
            );

        $storage
            ->method('findByTypeAndId')
            ->willReturn(new ArrayCollection([
                    'enrollments' => [
                        'sourcedId' => '12345',
                        'userSourcedId' => 'user_id',
                        'schoolSourcedId' => 'school_id',
                        'classSourcedId' => 'class_id',
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
