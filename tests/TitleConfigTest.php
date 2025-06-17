<?php

use PHPUnit\Framework\TestCase;

use NameParser\Config\TitleConfig;
use NameParser\NameParser;

class TitleConfigTest extends TestCase
{
    public function testCreatesDefaultConfiguration()
    {
        $config = new TitleConfig();
        
        $this->assertTrue($config->isValidTitle('Mr'));
        $this->assertTrue($config->isValidTitle('Mrs'));
        $this->assertTrue($config->isValidTitle('Dr'));
        $this->assertTrue($config->isValidTitle('Prof'));
    }
    
    public function testCreatesFullyCustomConfiguration()
    {
        $validTitles = ['mr', 'mrs', 'captain', 'colonel'];
        $mappings = ['captain' => 'Capt', 'colonel' => 'Col'];
        
        $config = TitleConfig::custom($validTitles, $mappings);
        
        $this->assertTrue($config->isValidTitle('Captain'));
        $this->assertFalse($config->isValidTitle('Dr')); // Not in custom list
        $this->assertEquals('Capt', $config->normalizeTitle('Captain'));
    }
    
    public function testNormalizesTitlesCaseInsensitively()
    {
        $config = new TitleConfig();
        
        $this->assertEquals('Mr', $config->normalizeTitle('MR'));
        $this->assertEquals('Mr', $config->normalizeTitle('mr'));
        $this->assertEquals('Mr', $config->normalizeTitle('Mr'));
    }
    
    public function testHandlesTitlesWithPeriods()
    {
        $config = new TitleConfig();
        
        $this->assertTrue($config->isValidTitle('Mr.'));
        $this->assertTrue($config->isValidTitle('Dr.'));
        $this->assertEquals('Mr', $config->normalizeTitle('Mr.'));
    }
    
    public function testAppliesDefaultMappings()
    {
        $config = new TitleConfig();
        
        $this->assertEquals('Mr', $config->normalizeTitle('Mister'));
    }
    
    public function testCapitalizesUnmappedTitles()
    {
        $config = new TitleConfig();
        
        $this->assertEquals('Sir', $config->normalizeTitle('sir'));
    }
    
    public function testCanBeUsedWithParser()
    {
        $militaryConfig = TitleConfig::custom(
            ['mr', 'mrs', 'captain', 'colonel'],
            ['captain' => 'Capt', 'colonel' => 'Col']
        );
        
        $parser = new NameParser($militaryConfig);
        
        $people = $parser->parse('Captain John Smith');
        $this->assertEquals('Capt', $people[0]->title);
        
        $people = $parser->parse('Colonel Jane Doe');
        $this->assertEquals('Col', $people[0]->title);
    }
    
}