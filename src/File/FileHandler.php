<?php

namespace oat\OneRoster\File;

class FileHandler
{
    /**
     * @param $filePath
     * @param string $mode
     * @param null $use_include_path
     * @return bool|resource
     * @throws \Exception
     */
    public function open($filePath, $mode = 'r')
    {
        if (!file_exists($filePath) || !is_readable($filePath) ||
            ($fileHandler = fopen($filePath, $mode)) === false) {
            throw new \Exception('File to import cannot be loaded.');
        }

        return $fileHandler;
    }

    /**
     * @param $filename
     * @return bool|string
     */
    public function getContents($filename)
    {
        return file_get_contents($filename);
    }

    /**
     * @param $handle
     * @param int $length
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     * @return array|false|null
     */
    public function readCsvLine($handle, $length = 0, $delimiter = ',', $enclosure = '"', $escape = '\\')
    {
        return fgetcsv($handle, $length, $delimiter, $enclosure, $escape);
    }
}