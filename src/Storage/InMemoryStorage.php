<?php

namespace oat\OneRoster\Storage;

use Doctrine\Common\Collections\ArrayCollection;

class InMemoryStorage extends ArrayCollection implements StorageInterface
{
    /**
     * @param string $typeOfEntity
     * @return ArrayCollection|mixed|null
     */
    public function findByType($typeOfEntity)
    {
        return $this->get($typeOfEntity);
    }

    /**
     * @param string $typeOfEntity
     * @param $id
     * @return array
     */
    public function findByTypeAndId($typeOfEntity, $id)
    {
        /** @var ArrayCollection $collection */
        $collection = $this->get($typeOfEntity);

        foreach ($collection as $item) {
            if ($item['sourcedId'] === $id) {
                return $item;
            }
        }
    }
}