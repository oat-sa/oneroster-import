<?php

namespace oat\OneRoster\Schema;

class FormatException extends \Exception
{
    const MESSAGE = 'Format of field %s it is invalid, it should be %s but it is %s.';

    /**
     * @param $field
     * @param $shouldBe
     * @param $itIs
     * @return static
     */
    public static function create($field, $shouldBe, $itIs)
    {
        return new static(sprintf(static::MESSAGE, $field, $shouldBe, $itIs));
    }
}