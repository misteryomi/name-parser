<?php

use PHPUnit\Framework\TestCase;
use NameParser\DTO\Person;

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
    
    public function testConvertsToArray()
    {
        $person = new Person('Dr', 'Jane', null, 'Doe');
        
        $expected = [
            'title' => 'Dr',
            'first_name' => 'Jane',
            'initial' => null,
            'last_name' => 'Doe'
        ];
        
        $this->assertEquals($expected, $person->toArray());
    }
    
    public function testConvertsToArrayWithAllNullOptionalFields()
    {
        $person = new Person('Ms', null, null, 'Johnson');
        
        $expected = [
            'title' => 'Ms',
            'first_name' => null,
            'initial' => null,
            'last_name' => 'Johnson'
        ];
        
        $this->assertEquals($expected, $person->toArray());
    }
    
    public function testHandlesHyphenatedLastNames()
    {
        $person = new Person('Mrs', 'Mary', null, 'Smith-Jones');
        
        $this->assertEquals('Smith-Jones', $person->last_name);
        $this->assertEquals('Smith-Jones', $person->toArray()['last_name']);
    }
    
    public function testHandlesMultiWordLastNames()
    {
        $person = new Person('Mrs', 'Faye', null, 'Hughes-Eastwood');
        
        $this->assertEquals('Hughes-Eastwood', $person->last_name);
        $this->assertEquals('Hughes-Eastwood', $person->toArray()['last_name']);
    }
    
    public function testHandlesSingleCharacterInitials()
    {
        $person = new Person('Prof', null, 'A', 'Einstein');
        
        $this->assertEquals('A', $person->initial);
        $this->assertEquals('A', $person->toArray()['initial']);
    }
    
    public function testPreservesTitleCase()
    {
        $person = new Person('PhD', 'John', null, 'Smith');
        
        $this->assertEquals('PhD', $person->title);
        $this->assertEquals('PhD', $person->toArray()['title']);
    }
    
    public function testPreservesNameCase()
    {
        $person = new Person('Mr', 'MacDonald', null, 'O\'Brien');
        
        $this->assertEquals('MacDonald', $person->first_name);
        $this->assertEquals('O\'Brien', $person->last_name);
    }
}