<?php
namespace TijmenWierenga\Bogus\Generator\MappingFile;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use TijmenWierenga\Bogus\Collection\BogusCollection;
use TijmenWierenga\Bogus\Collection\Collection;
use TijmenWierenga\Bogus\Config\Config;
use TijmenWierenga\Bogus\Exception\InvalidArgumentException as BogusInvalidArgumentException;
use TijmenWierenga\Bogus\Generator\Factory;

/**
 * Class MappingFileFactory
 * @package TijmenWierenga\Bogus\Generator\MappingFile
 */
class MappingFileFactory implements Factory
{
    /**
     * @var Config
     */
    private $config;

    /**
     * MappingFileFactory constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $entityClassName
     * @param string $methodName
     * @return Collection
     */
    public function build(string $entityClassName, string $methodName = 'build'): Collection
    {
        $callable = [$this->getHandler($entityClassName), $methodName];
        Assertion::isCallable($callable);

        return call_user_func($callable);
    }

    /**
     * @param string $entityClassName
     * @return string
     */
    private function getHandler(string $entityClassName): string
    {
        try {
            $handler = $this->config->get("{$entityClassName}.mapping");
            Assertion::notNull($handler);
        } catch (InvalidArgumentException $e) {
            throw new BogusInvalidArgumentException("No handler was registered for class '{$entityClassName}'");
        }

        return $handler;
    }
}
