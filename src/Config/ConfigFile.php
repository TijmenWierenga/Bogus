<?php
namespace TijmenWierenga\Bogus\Config;


use Assert\Assert;
use Assert\Assertion;

class ConfigFile
{
    /**
     * @var string
     */
    private $path;

    /**
     * ConfigFile constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        Assertion::file($path);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}