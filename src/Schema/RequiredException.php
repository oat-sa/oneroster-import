<?php

namespace oat\OneRoster\Schema;

class RequiredException extends \Exception
{
    const MESSAGE = 'Required field %s does not exists or it is empty';

    /**
     * @param $field
     * @return static
     */
    public static function create($field)
    {
        return new static(sprintf(static::MESSAGE, $field));
    }
}