<?php
namespace TijmenWierenga\Bogus\Factory;

class FactoryNotFoundException extends \RuntimeException
{
    public static function forEntity(string $entityClassName): self
    {
        return new self("No factory was found for {$entityClassName}");
    }
}
