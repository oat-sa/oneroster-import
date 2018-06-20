<?php

namespace oat\OneRoster\Entity;

class Demographic extends AbstractEntity
{
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
        return 'demographics';
    }
}