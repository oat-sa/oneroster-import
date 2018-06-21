<?php

namespace oat\OneRoster\Entity;

class CourseResource extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    public function getCourse()
    {
        return $this->getParentRelationEntity(Course::class);
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
       return 'courseResources';
    }
}