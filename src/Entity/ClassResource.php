<?php

namespace oat\OneRoster\Entity;

class ClassResource extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    public function getClass()
    {
        return $this->getParentRelationEntity(ClassRoom::class);
    }

    /**
     * @inheritdoc
     */
    public function getResource()
    {
        return $this->getParentRelationEntity(Resource::class);
    }

    /** @return  string */
    static public function getType()
    {
        return 'classResources';
    }
}