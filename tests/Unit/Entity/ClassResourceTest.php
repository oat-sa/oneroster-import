<?php

namespace oat\OneRoster\Tests\Unit\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\ClassResource;
use oat\OneRoster\Entity\ClassRoom;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Entity\Resource;
use oat\OneRoster\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class ClassResourceTest extends TestCase
{

    public function testGetClass()
    {
        $entity = $this->getEntity('classSourcedId');

        $this->assertInstanceOf(ClassRoom::class, $entity->getClass());
    }

    public function testGetResource()
    {
        $entity = $this->getEntity('resourceSourcedId');

        $this->assertInstanceOf(Resource::class, $entity->getResource());
    }

    public function testGetType()
    {
        $this->assertEquals('classResources', ClassResource::getType());
    }

    /**
     * @throws \ReflectionException
     */
    protected function getEntity($index)
    {
        $obj = new ClassResource();
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
                    'classResources' => [
                        'sourcedId' => '12345',
                        'classSourcedId' => 'class_id',
                        'resourceSourcedId' => 'resource_id',
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
