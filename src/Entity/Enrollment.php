<?php

namespace oat\OneRoster\Entity;

class Enrollment extends AbstractEntity
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
    public function getClasses()
    {
        return $this->getParentRelationEntities(ClassRoom::class);
    }

    /**
     * @inheritdoc
     */
    public function getUsers()
    {
        return $this->getParentRelationEntities(User::class);
    }

    /** @return  string */
    static public function getType()
    {
        return 'enrollments';
    }
}