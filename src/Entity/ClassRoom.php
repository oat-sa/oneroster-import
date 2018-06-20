<?php

namespace oat\OneRoster\Entity;

class ClassRoom extends AbstractEntity
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
    public function getEnrollments()
    {
        return $this->getChildrenRelationEntities(Enrollment::class);
    }

    /**
     * @inheritdoc
     */
    public function getAcademicSession()
    {
        return $this->getParentRelationEntity(AcademicSession::class);
    }

    /** @return  string */
    public static function getType()
    {
        return 'classes';
    }
}