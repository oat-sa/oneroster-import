<?php

namespace oat\OneRoster\Entity;

class Category extends AbstractEntity
{
    /** @return  string */
    static public function getType()
    {
       return 'categories';
    }
}