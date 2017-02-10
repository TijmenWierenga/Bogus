<?php
namespace TijmenWierenga\Bogus\Storage\Repository;

use Exception;
use Interop\Container\ContainerInterface;
use TijmenWierenga\Bogus\Collection\Collection;
use TijmenWierenga\Bogus\Config\Config;
use TijmenWierenga\Bogus\Exception\StorageException;
use TijmenWierenga\Bogus\Storage\StorageAdapter;

class RepositoryStorage implements StorageAdapter
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Config
     */
    private $config;

    /**
     * RepositoryStorage constructor.
     * @param ContainerInterface $container
     * @param Config $config
     */
    public function __construct(ContainerInterface $container, Config $config)
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
            $repoConfig = $this->config->get("{$className}.repository");

            $repository = $this->container->get($repoConfig['class']);
            $save = $repoConfig['method'];

            $repository->{$save}($collection);
        } catch (Exception $e) {
            throw new StorageException($e);
        }
    }
}
