<?php

namespace oat\OneRoster\Entity;

use Doctrine\Common\Collections\Criteria;
use oat\OneRoster\Entity\Factory\EntityFactory;
use oat\OneRoster\Storage\StorageInterface;

abstract class AbstractEntity implements EntityInterface
{
    /** @var string */
    protected $id;

    /** @var StorageInterface */
    protected $storage;

    /** @var RelationConfig */
    protected $relationConfig;

    /** @return  string */
    abstract static public function getType();

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getData()
    {
        return $this->storage->findByTypeAndId(static::getType(), $this->id)->first();
    }

    /**
     * @param StorageInterface $storage
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param RelationConfig $relationConfig
     */
    public function setRelationConfig(RelationConfig $relationConfig)
    {
        $this->relationConfig = $relationConfig;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $className
     * @param bool $inLineIds
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     * @throws \Exception
     */
    protected function getChildrenRelationEntities($className, $inLineIds = false)
    {
        $keyType   = $className::getType();
        $entities  = $this->storage->findByType($keyType);
        $index     = $this->relationConfig->getConfig(static::getType() . '.relations.' . $keyType . '.index');

        if (!is_null($inLineIds)){
            $criteria = Criteria::create()->where(Criteria::expr()->contains($index, $this->id));
        } else {
            $criteria = Criteria::create()->where(Criteria::expr()->eq($index, $this->id));
        }

        $results = $entities->matching($criteria);

        return EntityFactory::createCollection($className, $this->storage, $this->relationConfig, $results);
    }

    /**
     * @param $className
     * @param bool $inLineIds
     * @return \Doctrine\Common\Collections\ArrayCollection|EntityInterface
     * @throws \Exception
     */
    protected function getParentRelationEntity($className, $inLineIds = false)
    {
        $keyType   = $className::getType();
        $entities  = $this->storage->findByType($keyType);
        $index     = $this->relationConfig->getConfig(static::getType() . '.relations.' . $keyType . '.index');

        if ($inLineIds){
            $valueOfId = $this->getData()[$index];
            $criteria  = Criteria::create()->where(Criteria::expr()->in('sourcedId', explode(',', $valueOfId)));
            $results   = $entities->matching($criteria);

            return EntityFactory::createCollection($className, $this->storage, $this->relationConfig, $results);
        }

        $valueOfId = $this->getData()[$index];

        return EntityFactory::create($valueOfId, $className, $this->storage, $this->relationConfig);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function __debugInfo()
    {
        return $this->getData();
    }
}