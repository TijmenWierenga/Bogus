<?php
namespace TijmenWierenga\Bogus\Generator\MappingFile;

interface Mappable
{
    /**
     * This method builds the fixture
     *
     * @return Object  The created fixture
     */
    public static function build(iterable $attributes);
}
