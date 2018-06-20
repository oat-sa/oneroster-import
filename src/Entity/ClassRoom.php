<?php

namespace oat\OneRoster\Entity;

class ClassRoom extends AbstractEntity
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
    public function getEnrollments()
    {
        return $this->getChildrenRelationEntities(Enrollment::class);
    }

    /**
     * @inheritdoc
     */
    public function getAcademicSessions()
    {
        return $this->getParentRelationEntities(AcademicSession::class);
    }

    /** @return  string */
    public static function getType()
    {
        return 'classes';
    }
}