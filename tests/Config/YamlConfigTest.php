<?php
namespace TijmenWierenga\Bogus\Tests\Config;


use PHPUnit\Framework\TestCase;
use TijmenWierenga\Bogus\Config\ConfigFile;
use TijmenWierenga\Bogus\Config\YamlConfig;

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
    public function it_loads_a_config_file()
    {
        dump($this->config);
    }
}