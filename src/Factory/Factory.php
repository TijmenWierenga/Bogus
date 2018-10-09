<?php
namespace TijmenWierenga\Bogus\Factory;

interface Factory
{
    public function build(iterable $attributes): object;
    public function creates(string $entityClassName): bool;
}