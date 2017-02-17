<?php
namespace TijmenWierenga\Bogus\Generator\MappingFile;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
abstract class AbstractMapper implements Mappable
{
    /**
     * @param iterable $attributes
     */
    public static function build(iterable $attributes)
    {
        array_merge(self::attributes(), $attributes);
    }

    /**
     * @return array  An array of random attributes used to create a new fixture
     */
    abstract public function attributes(): array;

    /**
     * @param  array $attributes  An array with the random attributes combined with the overridden attributes
     * @return object             The constructed entity based on the provided attributes
     */
    abstract public function create(array $attributes);
}
