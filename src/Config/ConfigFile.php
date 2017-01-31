<?php
namespace TijmenWierenga\Bogus\Config;


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
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}