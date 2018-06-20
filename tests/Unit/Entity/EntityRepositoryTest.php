<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\EntityInterface;
use oat\OneRoster\Entity\EntityRepository;
use oat\OneRoster\Entity\Organisation;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class EntityRepositoryTest extends TestCase
{
    public function testGet()
    {
        $repo = new EntityRepository($this->mockStorage(), $this->mockRelationConfig('sourcedId'));

        $this->assertInstanceOf(EntityInterface::class, $repo->get('school_id', Organisation::class));
    }

    public function testGetAll()
    {
        $repo = new EntityRepository($this->mockStorage(), $this->mockRelationConfig('sourcedId'));

        $this->assertInstanceOf(ArrayCollection::class, $repo->getAll(Organisation::class));
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
