<?php

namespace oat\OneRoster\Entity;

class Demographic extends AbstractEntity
{
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
        return 'demographics';
    }
}