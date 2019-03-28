<?php

namespace oat\OneRoster\Schema;

class NotUniqueEntityException extends \RuntimeException
{
    public function __construct(string $sourcedId)
    {
        parent::__construct('Entity with sourcedId '. $sourcedId .' already exist.');
    }
}