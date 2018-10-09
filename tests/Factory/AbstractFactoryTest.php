<?php

namespace TijmenWierenga\Bogus\Tests\Factory;

use PHPStan\Testing\TestCase;
use TijmenWierenga\Bogus\Factory\AbstractFactory;

class AbstractFactoryTest extends TestCase
{
    /**
     * @var AbstractFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new class extends AbstractFactory {

            protected function attributes(): array
            {
                return [
                    "name" => "Tijmen"
                ];
            }

            protected function create(array $attributes): object
            {
                return new class($attributes["name"]) {
                    public $name;

                    public function __construct(string $name)
                    {
                        $this->name = $name;
                    }
                };
            }

            public function creates(string $entityClassName): bool
            {
                return true;
            }
        };
    }

    public function testItOverridesTheDefaultProperty()
    {
        $entity = $this->factory->build(["name" => "Henk"]);

        $this->assertEquals("Henk", $entity->name);
    }

    public function testItUsesTheDefaultProperties()
    {
        $entity = $this->factory->build([]);

        $this->assertEquals("Tijmen", $entity->name);
    }
}
