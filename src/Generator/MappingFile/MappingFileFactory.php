<?php
namespace TijmenWierenga\Bogus\Generator\MappingFile;


use TijmenWierenga\Bogus\Collection\Collection;
use TijmenWierenga\Bogus\Generator\Factory;

class MappingFileFactory implements Factory
{
    /**
     * MappingFileFactory constructor.
     */
    public function __construct()
    {
    }

    public function build(string $entityClassName): Collection
    {
        // TODO: Implement build() method.
    }
}