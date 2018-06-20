<?php


namespace oat\OneRoster\Entity;


use oat\OneRoster\Storage\StorageInterface;

interface EntityInterface
{
    /**
     * @return array
     */
    public function getData();

    /**
     * @param string $id
     */
    public function setId($id);

    /**
     * @param StorageInterface $storage
     */
    public function setStorage(StorageInterface $storage);

    /**
     * @param RelationConfig $relationConfig
     */
    public function setRelationConfig(RelationConfig $relationConfig);


    /** @return string */
    public static function getType();
}