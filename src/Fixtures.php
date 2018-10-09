<?php
namespace TijmenWierenga\Bogus;

use TijmenWierenga\Bogus\Factory\Factory;
use TijmenWierenga\Bogus\Factory\FactoryNotFoundException;

final class Fixtures
{
    /**
     * @var Factory[]
     */
    private $factories;

    public function __construct(Factory ...$factories)
    {
        $this->factories = $factories;
    }

    /**
     * @return object[]|iterable
     */
    public function create(string $entityClassName, iterable $attributes = [], int $amount = 1): iterable
    {
        $factory = $this->getFactoryFor($entityClassName);
        $result = [];

        for ($i = 0; $i < $amount; $i++) {
            $result[] = $factory->build($attributes);
        }

        return $result;
    }

    private function getFactoryFor(string $entityClassName): Factory
    {
        foreach ($this->factories as $factory) {
            if ($factory->creates($entityClassName)) return $factory;
        }

        throw FactoryNotFoundException::forEntity($entityClassName);
    }
}
