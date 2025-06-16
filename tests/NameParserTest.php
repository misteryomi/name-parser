<?php

use PHPUnit\Framework\TestCase;

use NameParser\NameParser;

class NameParserTest extends TestCase
{
    private NameParser $parser;

    protected function setUp(): void
    {
        $this->parser = new NameParser();
    }

    public function testBasicNameParsing()
    {
        $people = $this->parser->parse('Mr John Smith');
        
        $this->assertCount(1, $people);
        $this->assertEquals('Mr', $people[0]->title);
        $this->assertEquals('John', $people[0]->first_name);
        $this->assertEquals('Smith', $people[0]->last_name);
    }

    public function testMultiplePeople()
    {
        $people = $this->parser->parse('Mr and Mrs Smith');
        
        $this->assertCount(2, $people);
        $this->assertEquals('Mr', $people[0]->title);
        $this->assertEquals('Mrs', $people[1]->title);
        $this->assertEquals('Smith', $people[0]->last_name);
        $this->assertEquals('Smith', $people[1]->last_name);
    }

    public function testInitialParsing()
    {
        $people = $this->parser->parse('Mr J. Smith');
        
        $this->assertCount(1, $people);
        $this->assertEquals('Mr', $people[0]->title);
        $this->assertEquals('J', $people[0]->initial);
        $this->assertNull($people[0]->first_name);
        $this->assertEquals('Smith', $people[0]->last_name);
    }

    public function testArrayConversion()
    {
        $people = $this->parser->parse('Mr John Smith');
        $array = $people[0]->toArray();
        
        $expected = [
            'title' => 'Mr',
            'first_name' => 'John',
            'initial' => null,
            'last_name' => 'Smith'
        ];
        
        $this->assertEquals($expected, $array);
    }

    public function testEmptyString()
    {
        $people = $this->parser->parse('');
        $this->assertEmpty($people);
    }
}