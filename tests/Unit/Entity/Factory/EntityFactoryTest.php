<?php

namespace oat\OneRoster\Tests\Unit\Entity\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\EntityInterface;
use oat\OneRoster\Entity\Factory\EntityFactory;
use oat\OneRoster\Entity\Organisation;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class EntityFactoryTest extends TestCase
{

    /**
     * @throws \Exception
     * @throws \ReflectionException
     */
    public function testCreateCollection()
    {
        $collection = EntityFactory::createCollection(
            Organisation::class,
            $this->mockStorage(),
            $this->mockRelationConfig()
        );

        $this->assertInstanceOf(ArrayCollection::class, $collection);
    }

    /**
     * @throws \Exception
     * @throws \ReflectionException
     */
    public function testCreateCollectionWithInResults()
    {
        $inResults  = new ArrayCollection([
            'orgs' => [
                'sourcedId' => '12345'
            ]
        ]);

        $collection = EntityFactory::createCollection(
            Organisation::class,
            $this->mockStorage(),
            $this->mockRelationConfig(),
            $inResults
        );

        $this->assertInstanceOf(ArrayCollection::class, $collection);
    }

    /**
     * @throws \Exception
     * @throws \ReflectionException
     */
    public function testCreate()
    {
        $entity = EntityFactory::create(
            '12345',
            Organisation::class,
            $this->mockStorage(),
            $this->mockRelationConfig()
        );

        $this->assertInstanceOf(EntityInterface::class, $entity);
    }

    public function testCreateNonExistingEntity()
    {
        $this->expectException(\Exception::class);

        EntityFactory::create(
            '12345',
            'some/non/entity/class',
            $this->mockStorage(),
            $this->mockRelationConfig()
        );
    }

    /**
     * @throws \Exception
     * @throws \ReflectionException
     */
    public function testCreateCollectionNonValidClass()
    {
        $this->expectException(\Exception::class);

        $collection = EntityFactory::createCollection(
            'some/non/entity/class',
            $this->mockStorage(),
            $this->mockRelationConfig()
        );
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
            ->willReturn([
                'orgs' => [
                    'sourcedId' => '12345'
                ]
            ]);

        return $storage;
    }

    /**
     * @return RelationConfig
     */
    protected function mockRelationConfig()
    {
        return $this->getMockBuilder(RelationConfig::class)->disableOriginalConstructor()->getMock();
    }
}
