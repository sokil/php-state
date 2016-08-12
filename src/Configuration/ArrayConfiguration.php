<?php

namespace Sokil\State\Configuration;

use Sokil\State\Configuration;
use Sokil\State\Exception\InvalidConfigurationException;

/**
 * Class ArrayConfiguration
 * Used to build machine from PHP array configuration
 *
 * @package Sokil\State\Configuration
 */
class ArrayConfiguration extends Configuration
{
    private $path;

    private $config;

    /**
     * @param string|array $config path to configuration file with php array inside or simply php array
     * @throws InvalidConfigurationException
     */
    public function __construct($config)
    {
        if(is_array($config)) {
            $this->config = $config;
        } elseif (is_string($config)) {
            $this->path = $config;
        } else {
            throw new InvalidConfigurationException('Wrong array configuration specified. Must be array or path to file with php array.');
        }
    }

    protected function getConfig()
    {
        if (!$this->config) {
            $this->config = require($this->path);
        }

        return $this->config;
    }
}