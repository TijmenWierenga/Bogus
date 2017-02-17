# Bogus
[![Build Status](https://travis-ci.org/TijmenWierenga/Bogus.svg?branch=master)](https://travis-ci.org/TijmenWierenga/Bogus)

The dummy data factory

## Another package that generates dummy data models?
There are lots of packages available for quickly generating the dummy data you need for your application,
so why the need for another package doing the exact same thing?

I encountered the limitations of these packages once my storage system got more complicated.
Different storage engines, lots of repositories and advanced data models made it very difficult to
use the existing packages. Here is when I decided to create my own package.

This package enables you to create dummy data fixtures with custom attributes, having them stored the way you want (or not store them at all)
with one simple command:

``` php
$fixtures->create(YourApp\Model\User::class);
```

## Installation
The easiest and recommended way to install Bogus is by making use of [Composer](https://getcomposer.org/)
Run this command in the root directory of your project where your `composer.json` file is located:

``` bash
composer require --dev tijmen-wierenga/bogus
```

Most of the time you only want to use this package in an development environment, 
but if you want to make use it in production, just run the command without the `--dev` flag:

``` bash
composer require tijmen-wierenga/bogus
```

## Usage
The `FixturesInterface` just contains a single method:

``` php
interface FixturesInterface
{
    /**
     * Creates a new entity
     *
     * @param string $entityClassName
     * @param iterable $attributes
     * @param int $amount
     * @return Collection [$entityClassName]
     */
    public function create(string $entityClassName, iterable $attributes, int $amount): Collection;
}
```

This means you'll always call this method in order to generate fixtures. 
The implementation is highly configurable. 
The `Fixtures` base class implements this interface and accepts a storage adapter and a generator factory:

``` php
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
     * @param iterable $attributes
     * @param int $amount
     * @return Collection
     */
    public function create(string $entityClassName, iterable $attributes = [], int $amount = 1): Collection
    {
        $collection = $this->factory->build($entityClassName, $attributes, $amount);
        $this->storageAdapter->save($collection);

        return $collection;
    }
}
```

Constructing the Fixtures is as simple as this:

``` php
$storageAdapter = new TijmenWierenga\Bogus\Storage\InMemoryStorageAdapter();
$factory = // implementation of TijmenWierenga\Bogus\Generator\Factory interface
$fixtures = new Fixtures($storageAdapter, $factory);
```