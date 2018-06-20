<?php

use oat\OneRoster\Entity\ClassRoom;
use oat\OneRoster\Entity\EntityRepository;
use oat\OneRoster\Entity\Organisation;
use oat\OneRoster\Entity\RelationConfig;
use oat\OneRoster\File\FileHandler;
use oat\OneRoster\Service\ImportService;
use oat\OneRoster\Storage\InMemoryStorage;

require_once __DIR__ . '/../vendor/autoload.php';

$fileHandler = new FileHandler();
$importService = new ImportService($fileHandler);
$results = $importService->importMultiple(__DIR__ . '/../data/samples/oneRoster1.0/');

$storage = new InMemoryStorage($results);

$pathToSchemaJson = __DIR__ . '/../config/v1/relations.json';
$dataConfig = json_decode($fileHandler->getContents($pathToSchemaJson), true);

$relationConfig = new RelationConfig($dataConfig);

$entityRepository = new EntityRepository($storage, $relationConfig);

// get all organisation
$orgs = $entityRepository->getAll(Organisation::class);

// get one organisation
$org = $entityRepository->get('user1', \oat\OneRoster\Entity\User::class);
var_dump($org);

//get one class
/** @var ClassRoom $class */
$class = $entityRepository->get('class1', ClassRoom::class);
var_dump($class);

//get relations
var_dump($class->getEnrollments());
