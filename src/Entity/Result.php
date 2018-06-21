<?php

namespace oat\OneRoster\Entity;

class Result extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    public function getLineItem()
    {
        return $this->getParentRelationEntity(LineItem::class);
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
        return 'results';
    }
}