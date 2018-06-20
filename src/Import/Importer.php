<?php

namespace oat\OneRoster\Import;

use Doctrine\Common\Collections\ArrayCollection;
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

    /**
     * @param array $header
     * @param array $data
     * @return ArrayCollection
     */
    public function import(array $header, array $data)
    {
        $result = new ArrayCollection();
        foreach ($data as $index => $row){
            try {
                $rowWitHeader = array_combine($header, $row);
                $rowWitHeader = $this->schemaValidator->validate($rowWitHeader);

                $result->add($rowWitHeader);
            } catch (\Exception $e) {
               error_log($e->getMessage());
            }
        }

        return $result;
    }
}