<?php
namespace TijmenWierenga\Bogus\Config;

use Symfony\Component\Yaml\Yaml;
use TijmenWierenga\Bogus\Exception\InvalidArgumentException;

/**
 * Class YamlConfig
 * @package TijmenWierenga\Bogus\Config
 */
class YamlConfig implements Config
{
    /**
     * @var array
     */
    private $config;

    /**
     * YamlConfig constructor.
     * @param ConfigFile $configFile
     */
    public function __construct(ConfigFile $configFile)
    {
        $this->parseConfigFile($configFile);
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function get(string $value)
    {
        $keys = explode('.', $value);
        $path = $this->config;
        $x = 0;

        while (array_key_exists($keys[$x], $path)) {
            $path = $path[$keys[$x]];
            $x++;

            if ($x === count($keys)) {
                return $path;
            }
        }

        throw new InvalidArgumentException("Non existing config value '{$value}' was requested");
    }

    /**
     * @param ConfigFile $configFile
     */
    private function parseConfigFile(ConfigFile $configFile): void
    {
        $this->config = Yaml::parse(file_get_contents($configFile->getPath()));
    }
}
