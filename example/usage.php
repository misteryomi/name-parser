<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Misteryomi\NameParser\Parser\NameParser;


$customTitlesConfig = \Misteryomi\NameParser\Mappings\TitleConfig::custom(
    ['sir'],
    [
        'sir' => 'Sir',
    ]
);

$parser = new NameParser($customTitlesConfig);


$exampleNames = [
    'Dr. John Smith',
    'Ms. Jane Doe',
    'Mr. Alan Turing',
    'Prof. Ada Lovelace',
    'Sir Isaac Newton',
    'Dame Judi Dench'
];

// $parsedPeople = $parser->parseArray($exampleNames);

foreach ($exampleNames as $name) {
    $people = $parser->parse($name);
    echo "Input: '$name'\n";
    foreach ($people as $person) {
        echo "  -> " . json_encode($person->toArray()) . "\n";
    }
    echo "\n";
}
