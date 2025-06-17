<?php

require_once __DIR__ . '/../vendor/autoload.php';

use NameParser\NameParser;

$parser = new NameParser();

$parsedPeople = $parser->parseFromCSV(__DIR__ . '/example-data.csv', true);

echo json_encode($parsedPeople, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

// Example output
/*
[
    {
        "title": "Mr",
        "first_name": "John",
        "initial": null,
        "last_name": "Smith"
    },
    {
        "title": "Mrs",
        "first_name": "Jane",
        "initial": null,
        "last_name": "Doe"
    }
]
*/

// Note: Ensure the example-data.csv file exists in the same directory with appropriate data.
// The CSV should have a header row with 'title', 'first_name', 'initial', 'last_name' columns.