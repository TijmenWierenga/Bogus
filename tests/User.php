<?php
namespace TijmenWierenga\Bogus\Tests;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class User
{
    /**
     * @var string
     */
    private $name;

    /**
     * User constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
