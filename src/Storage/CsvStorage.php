<?php

namespace oat\OneRoster\Storage;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Service\ImportService;

class CsvStorage implements StorageInterface
{
    /** @var ImportService */
    private $importService;

    /**
     * CsvStorage constructor.
     * @param ImportService $importService
     */
    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * @param string $typeOfEntity [orgs,classes..]
     *
     * @return ArrayCollection
     * @throws \Exception
     */
    public function findByType($typeOfEntity)
    {
        $result = $this->importService->import($this->importService->getPathToFolder() . $typeOfEntity .'.csv', $typeOfEntity);

        return $result;
    }

    /**
     * @param string $typeOfEntity [orgs,classes..]
     *
     * @param $id
     * @return ArrayCollection
     * @throws \Exception
     */
    public function findByTypeAndId($typeOfEntity, $id)
    {
        $result = $this->importService->import($this->importService->getPathToFolder() . $typeOfEntity .'.csv', $typeOfEntity);

        return $result->filter(function ($entry) use ($id){
            if($entry['sourcedId'] === $id){
                return $entry;
            }
        });
    }
}