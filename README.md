# Bogus
[![Build Status](https://travis-ci.org/TijmenWierenga/Bogus.svg?branch=master)](https://travis-ci.org/TijmenWierenga/Bogus)

## Another package that generates dummy data models?
There are lots of packages available for quickly generating the dummy data you need for your application,
so why the need for another package doing the exact same thing?

I encountered the limitations of these packages once my storage system got more complicated.
Different storage engines, lots of repositories and advanced data models made it very difficult to
use the existing packages. Here is when I decided to create my own package.

**I'm currently upgrading the package to it's first major version and I'm unsure whether or not I'll continue to support storage. Extending the functionality with storage was complex and probably conflicts with the Single Responsibility Principle. I'll add my final decision to the release notes.**

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
The `Fixtures` class just contains a single method:

``` php
class Fixtures
{
    public function create(string $entityClassName, iterable $attributes, int $amount): iterable;
}
```

This means you'll always call this method in order to generate fixtures. 
The implementation is highly configurable.

