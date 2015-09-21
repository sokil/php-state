<?php

namespace Sokil\State\Configuration;

use Sokil\State\Configuration;

/**
 * Class ArrayConfiguration
 * Used to build machine from PHP array configuration
 *
 * @package Sokil\State\Configuration
 */
class ArrayConfiguration extends Configuration
{
    private $path;

    /**
     * @param string $path path to php array configuration file
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    protected function getConfig()
    {
        return require($this->path);
    }
}