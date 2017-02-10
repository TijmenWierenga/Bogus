<?php
namespace TijmenWierenga\Bogus\Generator\MappingFile;

interface Mappable
{
    /**
     * @return Object
     */
    public static function build(iterable $attributes);
}
