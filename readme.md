# Name Parser

A simple PHP library to parse generic names into a structured array format.

## Features

- Parse names from strings or CSV files
- Customizable title configuration
- Outputs structured data for each person

## Installation

Install via Composer:

```sh
composer require misteryomi/name-parser
```

## Usage

```php
require_once __DIR__ . '/vendor/autoload.php';

use NameParser\NameParser;

$parser = new NameParser();
$parsedPeople = $parser->parseFromCSV(__DIR__ . '/example/example-data.csv', true);

echo json_encode($parsedPeople, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
```

### Custom Titles

```php
$customTitles = [
    'Dr' => 'Doctor',
    'Mr' => 'Mister',
    'Mrs' => 'Mistress',
    'Ms' => 'Miss',
];
$customParser = new NameParser(new \NameParser\Config\TitleConfig($customTitles));
$customParsedPeople = $customParser->parseFromCSV(__DIR__ . '/example/example-data.csv', true);

echo json_encode($customParsedPeople, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
```

### Output Example

Parsing the string `Mr J. Smith` would return:

```json
[
  {
    "title": "Mr",
    "first_name": null,
    "initial": "J",
    "last_name": "Smith"
  }
]
```

## Testing

Run tests with PHPUnit:

```sh
vendor/bin/phpunit
```

## Project Structure

- `src/` - Library source code
- `tests/` - PHPUnit tests
- `example/` - Example usage and data

## License

MIT
