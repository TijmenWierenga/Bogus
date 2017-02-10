<?php
namespace TijmenWierenga\Bogus\Tests\Config;

use PHPUnit\Framework\TestCase;
use TijmenWierenga\Bogus\Config\ConfigFile;
use TijmenWierenga\Bogus\Config\YamlConfig;
use TijmenWierenga\Bogus\Exception\InvalidArgumentException;

class YamlConfigTest extends TestCase
{
    /**
     * @var YamlConfig
     */
    private $config;

    public function setUp()
    {
        $this->config = new YamlConfig(new ConfigFile(__DIR__ . '/TestConfig.yml'));
    }

    /**
    * @test
    */
    public function it_fails_when_non_existing_argument_is_requested()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->config->get('rubbish');
    }

    /**
    * @test
    */
    public function it_returns_the_value_of_a_config_key()
    {
    	$value = $this->config->get('key');

        $this->assertEquals('value', $value);
    }

    /**
    * @test
    */
    public function it_returns_a_nested_value()
    {
    	$value = $this->config->get('nested.key');

        $this->assertEquals('nested', $value);
    }

    /**
    * @test
    */
    public function if_fails_when_a_non_existing_nested_argument_is_requested()
    {
        $this->expectException(InvalidArgumentException::class);

    	$this->config->get('nested.rubbish');
    }

    /**
    * @test
    */
    public function it_returns_an_array_if_more_nesting_is_possible()
    {
    	$value = $this->config->get('nested');

        $this->assertArrayHasKey('key', $value);
    }
}
