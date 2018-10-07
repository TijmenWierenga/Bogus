<?php
namespace TijmenWierenga\Bogus;

class Fixtures
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

        return $factory->build($attributes, $amount);
    }

    private function getFactoryFor(string $entityClassName): Factory
    {
        foreach ($this->factories as $factory) {
            if ($factory->creates($entityClassName)) return $factory;
        }

        throw FactoryNotFoundException::forEntity($entityClassName);
    }
}
