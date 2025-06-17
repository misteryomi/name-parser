<?php

namespace NameParser\Data;

/**
 * Person - Represents a person with title, first name, initial, and last name.
 *
 * This class is used to encapsulate the details of a person parsed from a name string.
 * It provides a method to convert the person's details into an array format.
 */
class Person
{
    public function __construct(
        public ?string $title = null, 
        public ?string $first_name = null, 
        public ?string $initial = null,
        public ?string $last_name = null)
    {
    }
    
    /**
     * Convert to array format matching the original requirements
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'first_name' => $this->first_name,
            'initial' => $this->initial,
            'last_name' => $this->last_name
        ];
    }
}