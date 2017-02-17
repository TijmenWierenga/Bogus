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

### Generating random data
The `Factory` interface is responsible for generating data models. You can of course write your
own implementation, but I created a factory which makes it very easy to build data fixtures from scratch.

#### The Mapping File Factory
The Mapping File factory makes use of callables to generate dummy data. 
To create a new Mapping file simply generate a class and extend it with the `AbstractMapper` class:

``` php
namespace YourApp\Mapping\UserMapper

use TijmenWierenga\Bogus\Generator\MappingFile\AbstractMapper;
use TijmenWierenga\Bogus\Generator\MappingFile\Mappable;

class UserMapper extends AbstractMapper implements Mappable
{
    public static function attributes(): array
    {
        // Use Faker for generating dummy data
        $generator = Faker\Generator::create();
        
        return [
            'name' => $generator->firstName
        ];
    }

    public static function create(array $attributes)
    {
        return new User($attributes['name']);
    }
}
```

The UserMapper generates attributes in the `attributes()` function, 
they will be merged with the custom attributes you provided.
The merged attributes are then passed to the `create()` method where they are applied to the model.

##### Configuration
Now the mapping class is created it needs to be bound to the model.
This can be achieved through a configuration file. 
The package comes with a YAML configuration file handler by default.
A simple YAML configuration looks like this:

``` yml
YourApp\Model\User:                  # The full classname of your model
    mapping: YourApp\Mapping\UserMapper     # The full classname of the mapping class
```

##### Applying the configuration file to the MappingFileFactory

``` php
$configFile = new TijmenWierenga\Bogus\Config\ConfigFile(__DIR__ . '/location/of/mapping-config.yml');
$config = new TijmenWierenga\Bogus\Config\YamlConfig($configFile);
$factory = new TijmenWierenga\Bogus\Generator\MappingFile\MappingFileFactory($config);

$storageAdapter = new InMemoryStorageAdapter();
$fixtures = new Fixtures($storageAdapter, $factory);

$user = $fixtures->create(YourApp\Model\User::class, ['name' => 'Tijmen']); // This will return you a new User with 'Tijmen' as a name
```

