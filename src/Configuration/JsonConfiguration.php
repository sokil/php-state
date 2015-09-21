<?php

namespace Sokil\State\Configuration;

use Sokil\State\Configuration;

/**
 * Class JsonConfiguration
 * Used to build machine from JSON configuration
 *
 * @package Sokil\State\Configuration
 */
class JsonConfiguration extends Configuration
{
    private $path;

    /**
     * @param string $path path to JSON configuration file
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    protected function getConfig()
    {
        return json_decode(file_get_contents($this->path), true);
    }
}