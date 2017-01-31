<?php
namespace TijmenWierenga\Bogus\Tests\Config;


use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TijmenWierenga\Bogus\Config\ConfigFile;

class ConfigFileTest extends TestCase
{
    /**
    * @test
    */
    public function a_config_file_cannot_be_instantiated_from_a_non_existing_file()
    {
    	$this->expectException(InvalidArgumentException::class);

        new ConfigFile('/some/random/dir.yml');
    }

    /**
    * @test
    */
    public function it_can_create_a_config_file_from_existing_file()
    {
    	$configFile = new ConfigFile(__DIR__ . '/TestConfig.yml');

        $this->assertInstanceOf(ConfigFile::class, $configFile);
        $this->assertFileExists($configFile->getPath());
    }
}