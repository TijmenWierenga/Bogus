<?php
namespace TijmenWierenga\Bogus\Config;


class YamlConfig implements Config
{
    /**
     * @var ConfigFile
     */
    private $configFile;

    /**
     * YamlConfig constructor.
     * @param ConfigFile $configFile
     */
    public function __construct(ConfigFile $configFile)
    {
        $this->configFile = $configFile;
    }
}