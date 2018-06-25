<?php

namespace oat\OneRoster\Storage;

use Doctrine\Common\Collections\ArrayCollection;

interface StorageInterface
{
    /**
     * @param string $typeOfEntity [orgs,classes..]
     *
     * @return ArrayCollection
     */
    public function findByType($typeOfEntity);

    /**
     * @param string $typeOfEntity  [orgs,classes..]
     *
     * @param $id
     * @return array
     */
    public function findByTypeAndId($typeOfEntity, $id);
}