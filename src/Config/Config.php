<?php
namespace TijmenWierenga\Bogus\Config;

interface Config
{
    /**
     * Returns a config value
     *
     * @param string $value
     * @return mixed
     */
    public function get(string $value);
}
