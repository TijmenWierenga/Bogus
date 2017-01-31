<?php
namespace TijmenWierenga\Bogus;


use TijmenWierenga\Bogus\Generator\Factory;
use TijmenWierenga\Bogus\Storage\StorageAdapter;
use TijmenWierenga\Bogus\Collection\Collection;

class Fixtures implements FixturesInterface
{
    /**
     * @var StorageAdapter
     */
    private $storageAdapter;
    /**
     * @var Factory
     */
    private $factory;

    /**
     * Fixtures constructor.
     * @param StorageAdapter $storageAdapter
     * @param Factory $factory
     */
    public function __construct(StorageAdapter $storageAdapter, Factory $factory)
    {
        $this->storageAdapter = $storageAdapter;
        $this->factory = $factory;
    }

    /**
     * @param string $entityClassName
     * @return Collection
     */
    public function create(string $entityClassName): Collection
    {
        $collection = $this->factory->build($entityClassName);
        $this->storageAdapter->save($collection);

        return $collection;
    }
}
