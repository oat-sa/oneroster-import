<?php

namespace oat\OneRoster\Schema;

class Validator
{
    private const DATE_FORMAT = 'Y-m-d';
    private const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    private $schema;

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
    public function validate(array $dataRow): array
    {
        $this->validateRequiredFields($dataRow);
        return $this->validateFormat($dataRow);
    }

    /**
     * @param $dataRow
     * @throws RequiredException
     */
    protected function validateRequiredFields($dataRow): void
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
    protected function validateFormat(array $dataRow): array
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

            if ($format === 'date' || $format === 'datetime') {
                $dateFormat = $format === 'datetime' ? static::DATE_TIME_FORMAT : static::DATE_FORMAT;
                $value = \DateTime::createFromFormat($dateFormat, $value);
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
    protected function extractRequiresFields(): array
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
    protected function isFieldRequired($field): bool
    {
        $requiresFields = $this->extractRequiresFields();

        return in_array($field, $requiresFields, true);
    }

    public function __debugInfo()
    {
        return $this->schema;
    }
}