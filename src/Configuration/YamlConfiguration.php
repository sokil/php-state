<?php

namespace Sokil\State\Configuration;

use Sokil\State\Configuration;

/**
 * Class YamlConfiguration
 * Used to build machine from YAML configuration
 *
 * @package Sokil\State\Configuration
 */
class YamlConfiguration extends Configuration
{
    private $path;

    /**
     * @param string $path path to YAML configuration file
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    protected function getConfig()
    {
        return yaml_parse_file($this->path);
    }
}