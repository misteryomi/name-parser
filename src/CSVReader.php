<?php

namespace NameParser;

/**
 * Exception for CSV-related errors
 */
class CsvException extends \Exception {}

/**
 * A simple CSV reader - to handle CSV file I/O
 */
class CsvReader
{
    public function readNames(string $filePath, bool $hasHeader = true): array
    {
        if (!file_exists($filePath)) {
            throw new CsvException("CSV file not found: {$filePath}");
        }

        if (!is_readable($filePath)) {
            throw new CsvException("CSV file is not readable: {$filePath}");
        }

        $names = [];
        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            throw new CsvException("Unable to open CSV file: {$filePath}");
        }

        try {
            if ($hasHeader) {
                fgetcsv($handle);
            }

            $lineNumber = $hasHeader ? 2 : 1;
            while (($data = fgetcsv($handle)) !== false) {
                if (!empty($data[0])) {
                    $names[] = trim($data[0]);
                }
                $lineNumber++;
            }
        } finally {
            fclose($handle);
        }
        
        return $names;
    }
}