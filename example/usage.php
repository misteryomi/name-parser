<?php

require_once __DIR__ . '/../vendor/autoload.php';

use NameParser\NameParser;

$parser = new NameParser();

$parsedPeople = $parser->parseFromCSV(__DIR__ . '/example-data.csv', true);

echo json_encode($parsedPeople, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


// Using Custom Titles Configuration:

// $customTitles = [
//     'Dr' => 'Doctor',
//     'Mr' => 'Mister',
//     'Mrs' => 'Mistress',
//     'Ms' => 'Miss',
// ];
// $customParser = new NameParser(new \NameParser\Mappings\TitleConfig($customTitles));

// $customParsedPeople = $customParser->parseFromCSV(__DIR__ . '/example-data.csv', true);

// echo json_encode($customParsedPeople, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);