<?php

namespace oat\OneRoster\Import;

use oat\OneRoster\File\FileHandler;
use oat\OneRoster\Schema\Validator;

class ImporterFactory
{
    /** @var string */
    private $version;

    /** @var FileHandler */
    private $fileHandler;

    private $types = [
        'manifest' => 'manifest.json',
        'categories' => 'categories.json',
        'classResources' => 'classResources.json',
        'courseResources' => 'courseResources.json',
        'orgs' => 'orgs.json',
        'classes' => 'classes.json',
        'users' => 'users.json',
        'enrollments' => 'enrollments.json',
        'lineItems' => 'lineItems.json',
        'courses' => 'courses.json',
        'academicSessions' => 'academicSessions.json',
        'demographics' => 'demographics.json',
        'resources' => 'resources.json',
        'results' => 'results.json',
    ];

    /**
     * FactoryImporter constructor.
     * @param $version
     * @param FileHandler $fileHandler
     * @param array $types
     * [key => value] key = type of import, value = the json schema for validation
     */
    public function __construct($version, FileHandler $fileHandler, array $types = [])
    {
        $this->version = $version;
        $this->fileHandler = $fileHandler;
        $this->types = array_merge($this->types, $types);
    }

    /**
     * @param $type
     * @return ImporterInterface
     * @throws \Exception
     */
    public function build($type)
    {
        if (!array_key_exists($type, $this->types)) {
            throw new \Exception($type . ' not supported by FactoryImporter');
        }

        $pathToSchemaJson = __DIR__ . '/../../config/' . $this->version . '/' . $this->types[$type];
        $schema = json_decode($this->fileHandler->getContents($pathToSchemaJson), true);

        return new Importer(new Validator($schema));
    }
}