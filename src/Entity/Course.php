<?php

namespace oat\OneRoster\Entity;

class Course extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    public function getOrgs()
    {
        return $this->getParentRelationEntities(Organisation::class);
    }

    /** @return  string */
    static public function getType()
    {
        return 'courses';
    }
}