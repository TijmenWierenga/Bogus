<?php
namespace TijmenWierenga\Bogus\Generator;


use TijmenWierenga\Bogus\Collection\Collection;

/**
 * Interface Factory
 * @package TijmenWierenga\Bogus\Generator
 */
interface Factory
{
    /**
     * Creates dummy entities
     *
     * @param string $entityClassName
     * @return Collection
     */
    public function build(string $entityClassName): Collection;
}