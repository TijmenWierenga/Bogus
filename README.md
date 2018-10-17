# Bogus
[![Build Status](https://travis-ci.org/TijmenWierenga/Bogus.svg?branch=master)](https://travis-ci.org/TijmenWierenga/Bogus)

## A simple library to quickly generate fake data
Ever had to deal with the situation where you had to create dummy data to feed to a test? Newing up a lot of entities and passing the required arguments for all of them?
Bogus can help you by creating a very simple factory for your entities. Every factory will give you the possibility to define default (random) and overridable attributes for your entities. 

It's as simple as:
```php
$fixtures = new Fixtures(new UserFactory());
$users = $fixtures->create(User::class, ['city' => 'Amsterdam'], 5); // Generates 5 users from Amsterdam
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
The `Fixtures` class contains a single method:

``` php
final class Fixtures
{
    public function create(string $entityClassName, iterable $attributes, int $amount): iterable;
}
```

This means you'll always call this method in order to generate fixtures. 
The implementation is highly configurable.

### Factories
Random data is created through factories. The easiest way to implement a factory is by extending the AbstractFactory:

``` php
use TijmenWierenga\Bogus\Factory\AbstractFactory;

final class UserFactory extends AbstractFactory
{
    /**
     * Whether or not the Factory creates the entity passed as an argument
     */
    public function creates(string $entityClassName): bool
    {
        return $entityClassName === User::class;
    }

    /**
     * An iterable list of key => value pairs with default values. The result of the merged attributes
     * is passed to the 'create' method.
     */
    protected function attributes(): iterable
    {
        $factory = \Faker\Factory::create();

        return [
            "name" => $factory->firstName,
            "email" => $factory->email
        ];
    }

    /**
     * Creates the actual entity based on the merged attributes
     */
    protected function create(iterable $attributes): object
    {
        return new User($attributes["name"], $attributes["email"]);
    }
}

class User
{
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
}
```

Next, register the Factory to the Fixtures base class:
``` php
$fixtures = new Fixtures(new UserFactory());

// Use it
$fixtures->create(User::class); // Returns a random user instance
```

View the full [example](examples/abstract-factory.php).

### Overriding properties
If you wish to override a random property, you can provide a key-value list with overrides:
```php
$user = $fixtures->create(User::class, [
    "name" => "Tijmen"
]); // Will create a user with Tijmen as a name and a random email address
```

### Creating multiple entities at once
```php
$users = $fixtures->create(User::class, [], 3); // Will create 3 random users
```
