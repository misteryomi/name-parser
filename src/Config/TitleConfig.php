<?php

namespace NameParser\Config;

/**
 * TitleConfig - Configuration class for handling titles in name parsing.
 *
 * This class allows you to define valid titles and their mappings for normalization.
 * It provides methods to check if a title is valid and to normalize titles based on
 * the defined mappings.
 */
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

    private function getDefaultTitles(): array
    {
        return [
            'mr', 'mrs', 'ms', 'miss', 'dr', 'prof',
            'mister'
        ];
    }

    private function getDefaultMappings(): array
    {
        return [
            'mister' => 'Mr',
        ];
    }
}