<?php

require_once __DIR__ . '/../vendor/autoload.php';

use NameParser\NameParser;

$parser = new NameParser();

$parsedPeople = $parser->parseFromCSV(__DIR__ . '/example-data.csv', true);

echo print_r($parsedPeople);