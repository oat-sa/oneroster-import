<?php

namespace oat\OneRoster\Entity\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use oat\OneRoster\Entity\EntityInterface;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\Storage\StorageInterface;

class EntityFactory
{
    /**
     * @param $entityName
     * @param StorageInterface $storage
     * @param RelationConfig $relationConfig
     * @param Collection $inResults
     * @return ArrayCollection
     * @throws \Exception
     */
    public static function createCollection(
        $entityName,
        StorageInterface $storage,
        RelationConfig $relationConfig,
        Collection $inResults = null
    ) {
        if (!class_exists($entityName)){
            throw new \Exception($entityName. ' not a valid class');
        }

        $obj = new $entityName();
        if (!$obj instanceof EntityInterface) {
            throw new \Exception($entityName . ': invalid Entity Provided');
        }

        $allObjs = new ArrayCollection();

        if (is_null($inResults)) {
            $allResults = $storage->findByType($obj::getType());
        } else {
            $allResults = $inResults;
        }

        foreach ($allResults as $result) {
            $id = $result['sourcedId'];
            /** @var EntityInterface $objNew */
            $objNew = new $entityName();
            $objNew->setId($id);
            $objNew->setStorage($storage);
            $objNew->setRelationConfig($relationConfig);

            $allObjs->add($objNew);
        }

        return $allObjs;
    }

    /**
     * @param $id
     * @param $entityName
     * @param $storage
     * @param $relationConfig
     * @return EntityInterface
     * @throws \Exception
     */
    public static function create($id, $entityName, StorageInterface $storage, RelationConfig $relationConfig)
    {
        if (!class_exists($entityName)){
            throw new \Exception($entityName. ' not a valid class');
        }
        $obj = new $entityName();

        if (!$obj instanceof EntityInterface) {
            throw new \Exception($entityName . ': invalid Entity Provided');
        }
        $obj->setId($id);
        $obj->setStorage($storage);
        $obj->setRelationConfig($relationConfig);

        return $obj;
    }
}