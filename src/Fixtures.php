<?php
namespace TijmenWierenga\Bogus;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @return object[]|Collection
     */
    public function create(string $entityClassName, array $attributes = [], int $amount = 1): Collection
    {
        $factory = $this->getFactoryFor($entityClassName);
        $result = new ArrayCollection();

        for ($i = 0; $i < $amount; $i++) {
            $result->add($factory->build($attributes));
        }

        return $result;
    }

    private function getFactoryFor(string $entityClassName): Factory
    {
        foreach ($this->factories as $factory) {
            if ($factory->creates($entityClassName)) {
                return $factory;
            }
        }

        throw FactoryNotFoundException::forEntity($entityClassName);
    }
}
