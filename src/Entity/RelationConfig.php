<?php

namespace oat\OneRoster\Entity;

class RelationConfig
{
    /** @var array */
    private $dataConfig;

    /**
     * RelationConfig constructor.
     * @param array $dataConfig
     */
    public function __construct(array $dataConfig)
    {
        $this->dataConfig = $dataConfig;
    }

    /**
     * @param $configKey
     * @return mixed
     */
    public function getConfig($configKey)
    {
        $parts = explode('.', $configKey);

        $val = $this->iterate($this->dataConfig, $parts);

        return $val;
    }

    /**
     * @param array $data
     * @param array $parts
     * @return mixed
     */
    private function iterate(array $data, array $parts, $index = 0)
    {
        $value = $data[$parts[$index]];

        if (isset($parts[$index+1])) {
            if (!isset($value[$parts[$index+1]])){
                return null;
            }
            unset($parts[$index]);
            $index++;
            return $this->iterate($value, $parts, $index);
        }

        return $value;
    }

}