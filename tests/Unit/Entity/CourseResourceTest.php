<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\Course;
use oat\OneRoster\Entity\CourseResource;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Entity\Resource;
use oat\OneRoster\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class CourseResourceTest extends TestCase
{

    public function testGetCourse()
    {
        $entity = $this->getEntity('courseSourcedId');

        $this->assertInstanceOf(Course::class, $entity->getCourse());
    }

    public function testGetResource()
    {
        $entity = $this->getEntity('resourceSourcedId');

        $this->assertInstanceOf(Resource::class, $entity->getResource());
    }

    public function testGetType()
    {
        $this->assertEquals('courseResources', CourseResource::getType());
    }

    /**
     * @throws \ReflectionException
     */
    protected function getEntity($index)
    {
        $obj = new CourseResource();
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
                        'courseSourcedId' => 'course_id',
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
