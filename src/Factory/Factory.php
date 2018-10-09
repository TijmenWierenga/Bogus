<?php
namespace TijmenWierenga\Bogus\Factory;

interface Factory
{
    public function build(array $attributes): object;
    public function creates(string $entityClassName): bool;
}