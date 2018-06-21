<?php

namespace oat\OneRoster\Entity;

class Course extends AbstractEntity
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
    public function getAcademicCourse()
    {
        return $this->getParentRelationEntity(AcademicSession::class);
    }

    /** @return  string */
    static public function getType()
    {
        return 'courses';
    }
}