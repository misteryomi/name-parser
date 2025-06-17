<?php

use PHPUnit\Framework\TestCase;
use NameParser\Data\Person;

class PersonTest extends TestCase
{
    public function testCreatesPersonWithAllFields()
    {
        $person = new Person('Mr', 'John', 'M', 'Smith');
        
        $this->assertEquals('Mr', $person->title);
        $this->assertEquals('John', $person->first_name);
        $this->assertEquals('M', $person->initial);
        $this->assertEquals('Smith', $person->last_name);
    }
    
    public function testCreatesPersonWithNullFields()
    {
        $person = new Person('Mr', null, null, 'Smith');
        
        $this->assertEquals('Mr', $person->title);
        $this->assertNull($person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Smith', $person->last_name);
    }
    
    public function testHandlesHyphenatedLastNames()
    {
        $person = new Person('Mrs', 'Faye', null, 'Hughes-Eastwood');
        
        $this->assertEquals('Hughes-Eastwood', $person->last_name);
    }
    
    public function testHandlesSingleCharacterInitials()
    {
        $person = new Person('Prof', null, 'A', 'Brogan');
        
        $this->assertEquals('A', $person->initial);
    }
    
}