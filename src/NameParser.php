<?php

namespace NameParser;

use NameParser\DTO\Person;
use NameParser\Mappings\TitleConfig;

class NameParser
{

    private $titleConfig;

    public function __construct(?TitleConfig $titleConfig = null) 
    {
        $this->titleConfig = $titleConfig ?? new TitleConfig();
    }

    public function parseFromCSV(string $filePath, bool $hasHeader = true): array
    {
        if (!file_exists($filePath)) 
        {
            throw new \Exception("CSV file not found in: {$filePath}");
        }

        $people = [];
        $handle = fopen($filePath, 'r');

        if ($hasHeader) 
        {
            fgetcsv($handle);
        }

        while (($data = fgetcsv($handle)) !== false) 
        {
            if (!empty($data[0]))
            {
                $people = array_merge($people, $this->parse($data[0]));
            }
        }

        fclose($handle);
        
        return $people;
    }

    public function parse(string $nameString): array
    {
        $nameString = trim($nameString);

        if (empty($nameString)) 
        {
            return [];
        }

        if (preg_match('/\s+(and|&|\+)\s+/i', $nameString, $matches, PREG_OFFSET_CAPTURE))
        {
            return $this->parseMultiplePeople($nameString, $matches[0][0]);
        }

        return [$this->parseSinglePerson($nameString)];
    }

    public function getTitleConfig(): TitleConfig
    {
        return $this->titleConfig;
    }

    public function setTitleConfig(TitleConfig $titleConfig): void
    {
        $this->titleConfig = $titleConfig;
    }

    private function parseMultiplePeople(string $nameString, string $conjunction): array
    {
        $parts = preg_split('/\s+(and|&|\+)\s+/i', $nameString);
        $people = [];
        
        $firstPart = trim($parts[0]);
        $secondPart = trim($parts[1]);
        $secondWords = explode(' ', $secondPart);
        
        if (count($secondWords) == 2 && $this->titleConfig->isValidTitle($secondWords[0])) 
        {

            $sharedLastName = $secondWords[1];
            
            $firstPerson = $this->parseSinglePerson($firstPart);
            $firstPerson->last_name = $sharedLastName;
            $people[] = $firstPerson;
            
            $people[] = new Person(
                $this->titleConfig->normalizeTitle($secondWords[0]),
                null,
                null,
                $sharedLastName
            );
        } else {
            $people[] = $this->parseSinglePerson($firstPart);
            $people[] = $this->parseSinglePerson($secondPart);
        }
        
        return $people;
    }

    private function parseSinglePerson(string $nameString): Person
    {
        $words = array_filter(explode(' ', trim($nameString)));

        $person = new Person(null, null, null, null);

        $index = 0;

        // Extract ther person's title
        if (isset($words[$index]) && $this->titleConfig->isValidTitle($words[$index]))
        {
            $person->title = $this->titleConfig->normalizeTitle($words[$index]);

            $index++;
        }

        // If we only have title + one word, that word is last name
        if ($index == (count($words) - 1))
        {
            $person->last_name = $words[$index];

            return $person;
        }

        if (isset($words[$index])) 
        {
            if ($this->isInitial(($words[$index])))
            {
                $person->initial = strtoupper(rtrim($words[$index], '.'));

                $index++;
            } else {
                $person->first_name = $words[$index];

                $index++;
            }
        }

        // Mark any remaining words as last name
        if ($index < count($words)) 
        {
            $person->last_name = implode(' ', array_slice($words, $index));
        }

        return $person;
    }

    private function isInitial(string $word): bool
    {
        return preg_match('/^[A-Za-z].?$/', $word);
    }
}