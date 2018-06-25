<?php

namespace oat\OneRoster\Storage;

use Doctrine\Common\Collections\ArrayCollection;

class InMemoryStorage extends ArrayCollection implements StorageInterface
{
    /** @var array */
    private $imports;

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
        $key = $typeOfEntity . '_' . $id;

        if (isset($this->imports[$key])) {
            return $this->imports[$key];
        }

        /** @var ArrayCollection $collection */
        $collection = $this->get($typeOfEntity);

        foreach ($collection as $item) {
            if ($item['sourcedId'] === $id) {
                $this->imports[$key] = $item;
                return $item;
            }
        }
    }
}