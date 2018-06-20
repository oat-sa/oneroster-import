<?php


namespace oat\OneRoster\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\Factory\EntityFactory;
use oat\OneRoster\Storage\StorageInterface;

class EntityRepository
{
    /** @var StorageInterface */
    private $storage;

    /** @var RelationConfig */
    private $relationConfig;

    /**
     * EntityManager constructor.
     * @param StorageInterface $storage
     * @param RelationConfig $relationConfig
     */
    public function __construct(StorageInterface $storage, RelationConfig $relationConfig)
    {
        $this->storage = $storage;
        $this->relationConfig = $relationConfig;
    }

    /**
     * @param string $id
     * @param string $entityName
     * @return EntityInterface
     * @throws \Exception
     */
    public function get($id, $entityName)
    {
        return EntityFactory::create($id, $entityName, $this->storage, $this->relationConfig);
    }

    /**
     * @param string $entityName
     * @return ArrayCollection
     * @throws \Exception
     */
    public function getAll($entityName)
    {
        return EntityFactory::createCollection($entityName, $this->storage, $this->relationConfig);
    }
}