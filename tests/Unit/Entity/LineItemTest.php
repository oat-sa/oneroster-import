<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\AcademicSession;
use oat\OneRoster\Entity\Category;
use oat\OneRoster\Entity\ClassRoom;
use oat\OneRoster\Entity\LineItem;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class LineItemTest extends TestCase
{

    public function testGetClass()
    {
        $entity = $this->getEntity('classSourcedId');

        $this->assertInstanceOf(ClassRoom::class, $entity->getClass());
    }

    public function testGetCategory()
    {
        $entity = $this->getEntity('categorySourcedId');

        $this->assertInstanceOf(Category::class, $entity->getCategory());
    }

    public function testGetAcademicCourse()
    {
        $entity = $this->getEntity('gradingPeriodSourcedId');

        $this->assertInstanceOf(AcademicSession::class, $entity->getAcademicSession());
    }

    public function testGetType()
    {
        $this->assertEquals('lineItems', LineItem::getType());
    }

    /**
     * @throws \ReflectionException
     */
    protected function getEntity($index)
    {
        $obj = new LineItem();
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
                        'classSourcedId' => 'course_id',
                        'categorySourcedId' => 'category_id',
                        'gradingPeriodSourcedId' => 'ac_sess_id',
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
