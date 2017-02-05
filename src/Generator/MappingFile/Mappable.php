<?php
namespace TijmenWierenga\Bogus\Generator\MappingFile;

use TijmenWierenga\Bogus\Collection\Collection;

interface Mappable
{
    /**
     * @return Collection
     */
    public static function build(): Collection;
}
