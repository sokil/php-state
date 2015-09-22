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

    private $options = [
        'pecl' => true,
    ];

    /**
     * @param string $path path to YAML configuration file
     */
    public function __construct($path, array $options = null)
    {
        $this->path = $path;

        if ($options) {
            $this->options = array_merge($this->options, $options);
        }
    }

    protected function getConfig()
    {
        // use native pecl extension
        if ($this->options['pecl']) {
            return yaml_parse_file($this->path);
        }

        // use Symfony component
        $parser = new \Symfony\Component\Yaml\Parser();
        return $parser->parse(file_get_contents($this->path));
    }
}