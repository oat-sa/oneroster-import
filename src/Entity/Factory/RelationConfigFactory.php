<?php

namespace oat\OneRoster\Entity\Factory;

use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\File\FileHandler;

class RelationConfigFactory
{
    /** @var FileHandler */
    private $fileHandler;

    /**
     * RelationConfigFactory constructor.
     * @param FileHandler $fileHandler
     */
    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    /**
     * @return RelationConfig
     */
    public function create()
    {
        $pathToSchemaJson = __DIR__ . '/../../config/v1/relations.json';
        $dataConfig       = json_decode($this->fileHandler->getContents($pathToSchemaJson), true);

        return new RelationConfig($dataConfig);
    }
}