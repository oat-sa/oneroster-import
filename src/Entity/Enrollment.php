<?php

namespace oat\OneRoster\Entity;

class Enrollment extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    public function getOrg()
    {
        return $this->getParentRelationEntity(Organisation::class);
    }

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
    public function getUser()
    {
        return $this->getParentRelationEntity(User::class);
    }

    /** @return  string */
    static public function getType()
    {
        return 'enrollments';
    }
}