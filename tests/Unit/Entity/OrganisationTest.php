<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\Organisation;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class OrganisationTest extends TestCase
{

    public function testGetClasses()
    {
        $entity = $this->getEntity('sourcedId');

        $this->assertInstanceOf(ArrayCollection::class, $entity->getClasses());
    }

    public function testGetUsers()
    {
        $entity = $this->getEntity('sourcedId');

        $this->assertInstanceOf(ArrayCollection::class, $entity->getUsers());
    }

    public function testGetEnrollments()
    {
        $entity = $this->getEntity('sourcedId');

        $this->assertInstanceOf(ArrayCollection::class, $entity->getEnrollments());
    }

    public function testGetType()
    {
        $this->assertEquals('orgs', Organisation::getType());
    }

    /**
     * @throws \ReflectionException
     */
    protected function getEntity($index)
    {
        $obj = new Organisation();
        $obj->setId('org_id');
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
                    'orgs' => [
                        'sourcedId' => 'org_id',
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
