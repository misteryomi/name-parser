<?php

namespace NameParser\Mappings;

class TitleConfig
{
    /**
     * @var array<string, string>
     */

    private array $validTitles;

    private array $titleMappings;


    public function __construct(
        ?array $validTitles = null, 
        ?array $titleMappings = null
    ) {
        $this->validTitles = $validTitles ?? $this->getDefaultTitles();
        $this->titleMappings = $titleMappings ?? $this->getDefaultMappings();
    }

    public static function withValidTitles(array $titles): self
    {
        return new self($titles);
    }

    public static function withMappings(array $mappings): self
    {
        return new self(null, $mappings);
    }

    public static function custom(array $validTitles, array $titleMappings): self
    {
        return new self($validTitles, $titleMappings);
    }

    public function isValidTitle(string $title): bool
    {
        return in_array(strtolower(rtrim($title, '.')), $this->validTitles);
    }

    public function normalizeTitle(string $title): string
    {
        $cleaned = strtolower(rtrim($title, '.'));

        if (isset($this->titleMappings[$cleaned]))
        {
            return $this->titleMappings[$cleaned];
        }

        return ucfirst($cleaned);
    }

    public function getValidTitles(): array
    {
        return $this->validTitles;
    }

    public function getTitleMappings(): array
    {
        return $this->titleMappings;
    }

    private function getDefaultTitles(): array
    {
        return [
            'mr', 'mrs', 'ms', 'miss', 'dr', 'prof', 'professor',
            'mister'
        ];
    }

    private function getDefaultMappings(): array
    {
        return [
            'mister' => 'Mr',
            'professor' => 'Prof',
            'reverend' => 'Rev',
            'honourable' => 'Hon'
        ];
    }
}