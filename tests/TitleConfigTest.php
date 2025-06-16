<?php

use PHPUnit\Framework\TestCase;

use NameParser\Mappings\TitleConfig;
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
    
    public function testCreatesCustomValidTitlesConfiguration()
    {
        $config = TitleConfig::withValidTitles(['mr', 'mrs', 'captain']);
        
        $this->assertTrue($config->isValidTitle('Mr'));
        $this->assertTrue($config->isValidTitle('Captain'));
        $this->assertFalse($config->isValidTitle('Dr')); // Not in custom list
    }
    
    public function testCreatesCustomMappingsConfiguration()
    {
        $config = TitleConfig::withMappings([
            'captain' => 'Capt',
            'colonel' => 'Col'
        ]);
        
        // Should still have default titles
        $this->assertTrue($config->isValidTitle('Mr'));
        
        // Should use custom mappings
        $this->assertEquals('Capt', $config->normalizeTitle('Captain'));
        $this->assertEquals('Col', $config->normalizeTitle('Colonel'));
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
        $this->assertEquals('Prof', $config->normalizeTitle('Professor'));
        $this->assertEquals('Rev', $config->normalizeTitle('Reverend'));
        $this->assertEquals('Hon', $config->normalizeTitle('Honourable'));
    }
    
    public function testCapitalizesUnmappedTitles()
    {
        $config = new TitleConfig();
        
        $this->assertEquals('Sir', $config->normalizeTitle('sir'));
        $this->assertEquals('Dame', $config->normalizeTitle('dame'));
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
    
    public function testCanChangeParserConfigurationAtRuntime()
    {
        $parser = new NameParser();
        
        // Default configuration - Captain not recognized
        $people = $parser->parse('Captain Smith');
        $this->assertNull($people[0]->title); // No title recognized
        $this->assertEquals('Captain', $people[0]->first_name); // Treated as first name
        
        // Change to military configuration
        $militaryConfig = TitleConfig::withValidTitles(['mr', 'mrs', 'captain']);
        $parser->setTitleConfig($militaryConfig);
        
        $people = $parser->parse('Captain Smith');
        $this->assertEquals('Captain', $people[0]->title);
        $this->assertNull($people[0]->first_name);
    }
    
    public function testProvidesAccessToConfigurationData()
    {
        $validTitles = ['mr', 'mrs', 'captain'];
        $mappings = ['captain' => 'Capt'];
        
        $config = TitleConfig::custom($validTitles, $mappings);
        
        $this->assertEquals($validTitles, $config->getValidTitles());
        $this->assertEquals($mappings, $config->getTitleMappings());
    }
}