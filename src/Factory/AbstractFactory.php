<?php

namespace TijmenWierenga\Bogus\Factory;

abstract class AbstractFactory implements Factory
{
    public function build(array $attributes): object
    {
        $attributes = array_merge($this->attributes(), $attributes);

        return $this->create($attributes);
    }

    /**
     * Whether or not the Factory creates the entity passed as an argument
     */
    abstract public function creates(string $entityClassName): bool;

    /**
     * An iterable list of key => value pairs with default values. The result of the merged attributes
     * is passed to the 'create' method.
     */
    abstract protected function attributes(): array;

    /**
     * Creates the actual entity based on the merged attributes
     */
    abstract protected function create(array $attributes): object;
}
