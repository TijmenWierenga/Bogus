<?php
namespace TijmenWierenga\Bogus\Storage\Repository;


use Exception;
use TijmenWierenga\Bogus\Collection\Collection;
use TijmenWierenga\Bogus\Config\Config;
use TijmenWierenga\Bogus\Container\Container;
use TijmenWierenga\Bogus\Exception\StorageException;
use TijmenWierenga\Bogus\Storage\StorageAdapter;

class RepositoryStorage implements StorageAdapter
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Config
     */
    private $config;

    /**
     * RepositoryStorage constructor.
     * @param Container $container
     * @param Config $config
     */
    public function __construct(Container $container, Config $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * @param Collection $collection
     */
    public function save(Collection $collection): void
    {
        try {
            $className = get_class($collection->first());
            $classConfig = $this->config->get($className);

            $repository = $this->container->get($classConfig['repository']);
            $save = $classConfig['save'];

            $repository->{$save}($collection);
        } catch (Exception $e) {
            throw new StorageException($e);
        }
    }
}