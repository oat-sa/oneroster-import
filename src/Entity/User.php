<?php

namespace oat\OneRoster\Entity;

class User extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    public function getOrgs()
    {
        return $this->getParentRelationEntities(Organisation::class);
    }

    /**
     * @inheritdoc
     */
    public function getDemographics()
    {
        return $this->getChildrenRelationEntities(Demographic::class);
    }

    /**
     * @inheritdoc
     */
    public function getEnrollments()
    {
        return $this->getChildrenRelationEntities(Enrollment::class);
    }

    /** @return  string */
    static public function getType()
    {
        return 'users';
    }
}