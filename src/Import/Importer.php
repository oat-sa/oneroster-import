<?php

namespace oat\OneRoster\Import;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Schema\UniqueEntityException;
use oat\OneRoster\Schema\Validator;

class Importer implements ImporterInterface
{
    /** @var Validator */
    private $schemaValidator;

    /**
     * Importer constructor.
     * @param Validator $schemaValidator
     */
    public function __construct(Validator $schemaValidator)
    {
        $this->schemaValidator = $schemaValidator;
    }

    public function import(array $header, array $data): ArrayCollection
    {
        $result = new ArrayCollection();

        foreach ($data as $index => $row){
            $rowWitHeader = array_combine($header, $row);
            $rowWitHeader = $this->schemaValidator->validate($rowWitHeader);

            if (isset($rowWitHeader['sourcedId'])){
                if ($result->containsKey($rowWitHeader['sourcedId'])) {
                    throw new UniqueEntityException($rowWitHeader['sourcedId']);
                }

                $result->set($rowWitHeader['sourcedId'], $rowWitHeader);
            } else {
                $result->add($rowWitHeader);
            }
        }

        return $result;
    }
}