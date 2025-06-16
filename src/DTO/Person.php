<?php

namespace Misteryomi\NameParser\DTO;

class Person 
{

    public $title;
    public $first_name;
    public $initial;
    public $last_name;

    public function __construct(
        ?string $title = null,
        ?string $first_name = null,
        ?string $initial = null,
        ?string $last_name = null
    ) {
        $this->title = $title;
        $this->first_name = $first_name;
        $this->initial = $initial;
        $this->last_name = $last_name;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'first_name' => $this->first_name,
            'initial' => $this->initial,
            'last_name' => $this->last_name,
        ];
    }
}
