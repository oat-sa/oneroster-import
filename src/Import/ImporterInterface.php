<?php

namespace oat\OneRoster\Import;

use Doctrine\Common\Collections\ArrayCollection;

interface ImporterInterface
{
    /**
     * @param array $header
     * @param array $data
     * @return ArrayCollection
     */
    public function import(array $header, array $data): ArrayCollection;
}