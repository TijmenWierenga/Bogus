<?php
namespace TijmenWierenga\Bogus;

interface Factory
{
    /**
     * @return object[]|iterable
     */
    public function build(iterable $attributes, int $amount): iterable;
    public function creates(string $entityClassName): bool;
}