<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\Demographic;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Entity\User;
use oat\OneRoster\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class DemographicTest extends TestCase
{

    public function testGetUsers()
    {
        $entity = $this->getEntity('userSourcedId');

        $this->assertInstanceOf(User::class, $entity->getUser());
    }

    public function testGetType()
    {
        $this->assertEquals('demographics', Demographic::getType());
    }

    /**
     * @throws \ReflectionException
     */
    protected function getEntity($index)
    {
        $obj = new Demographic();
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
                    'users' => [
                        'sourcedId' => 'user_id'
                    ],
                ])
            );

        $storage
            ->method('findByTypeAndId')
            ->willReturn(new ArrayCollection([
                    'demographics' => [
                        'sourcedId' => '12345',
                        'userSourcedId' => 'user_id',
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
