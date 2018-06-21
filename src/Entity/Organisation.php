<?php

namespace oat\OneRoster\Entity;

class Organisation extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    public function getClasses()
    {
        return $this->getChildrenRelationEntities(ClassRoom::class);
    }

    /**
     * @inheritdoc
     */
    public function getUsers()
    {
        return $this->getChildrenRelationEntities(User::class, true);
    }

    /**
     * @inheritdoc
     */
    public function getEnrollments()
    {
        return $this->getChildrenRelationEntities(Enrollment::class);
    }

    /**
     * @return string
     */
    public static function getType()
    {
        return 'orgs';
    }
}