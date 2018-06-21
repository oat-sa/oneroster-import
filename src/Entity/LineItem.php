<?php

namespace oat\OneRoster\Entity;

class LineItem extends AbstractEntity
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
    public function getCategory()
    {
        return $this->getParentRelationEntity(Category::class);
    }

    /**
     * @inheritdoc
     */
    public function getAcademicSession()
    {
        return $this->getParentRelationEntity(AcademicSession::class);
    }

    /** @return  string */
    static public function getType()
    {
        return 'lineItems';
    }
}