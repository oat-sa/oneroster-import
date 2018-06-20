<?php

namespace oat\OneRoster\Schema;

class Validator
{
    /** @var array */
    private $schema = array();

    /**
     * Validator constructor.
     * @param array $schema
     */
    public function __construct(array $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @param array $dataRow
     * @return array
     * @throws RequiredException
     * @throws FormatException
     */
    public function validate(array $dataRow)
    {
        $this->validateRequiredFields($dataRow);
        return $this->validateFormat($dataRow);
    }

    /**
     * @param $dataRow
     * @throws RequiredException
     */
    protected function validateRequiredFields($dataRow)
    {
        $requiresFields = $this->extractRequiresFields();

        foreach ($requiresFields as $requiredField) {
            if (!isset($dataRow[$requiredField])
                || empty($dataRow[$requiredField])) {
                throw RequiredException::create($requiredField);
            }
        }
    }

    /**
     * @param array $dataRow
     * @return array
     * @throws FormatException
     */
    protected function validateFormat(array $dataRow)
    {
        foreach ($this->schema as $itemSchema) {
            $columnIdentifier = $itemSchema['columnId'];
            if (!isset($dataRow[$columnIdentifier])){
                continue;
            }

            $format = $itemSchema['format'];
            $value = $dataRow[$columnIdentifier];

            if ($format === 'boolean') {
                $value = boolval($value);
            }

            if ($format === 'date') {
                $value = \DateTime::createFromFormat('Y-m-d', $value);
                if ($value === false && $this->isFieldRequired($columnIdentifier)) {
                    throw FormatException::create($columnIdentifier, $format, gettype($value));
                }

            } else {
                if (gettype($value) !== $format && $this->isFieldRequired($columnIdentifier)) {
                    throw FormatException::create($columnIdentifier, $format, gettype($value));
                }
            }

            $dataRow[$columnIdentifier] = $value;
        }

        return $dataRow;
    }

    /**
     * @return array
     */
    protected function extractRequiresFields()
    {
        $required = [];

        foreach ($this->schema as $item) {
            if ($item['required'] === true) {
                $required[] = $item['columnId'];
            }
        }

        return $required;
    }

    /**
     * @param $field
     * @return bool
     */
    protected function isFieldRequired($field)
    {
        $requiresFields = $this->extractRequiresFields();

        return in_array($field, $requiresFields);
    }
}