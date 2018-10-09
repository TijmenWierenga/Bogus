<?php

namespace TijmenWierenga\Bogus\Factory;

abstract class AbstractFactory implements Factory
{
    /**
     * @return object
     */
    public function build(iterable $attributes): object
    {
        $attributes = array_merge($this->attributes(), $attributes);

        return $this->create($attributes);
    }

    abstract public function creates(string $entityClassName): bool;
    abstract protected function attributes(): iterable;
    abstract protected function create(iterable $attributes): object;
}
