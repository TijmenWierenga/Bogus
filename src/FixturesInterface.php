<?php
namespace TijmenWierenga\Bogus;

use TijmenWierenga\Bogus\Collection\Collection;

/**
 * Interface FixturesInterface
 * @package TijmenWierenga\Bogus
 */
interface FixturesInterface
{
    /**
     * Creates a new entity
     *
     * @param string $entityClassName
     * @param iterable $attributes
     * @param int $amount
     * @return Collection [$entityClassName]
     */
    public function create(string $entityClassName, iterable $attributes, int $amount): Collection;
}
