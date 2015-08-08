<?php

namespace Sokil\State;

class State
{
    /**
     * @var string State name
     */
    private $name;

    /**
     * @var array State metadata
     */
    private $metadata;

    public function __construct($name, array $metadata = [])
    {
        $this->name = $name;
        $this->metadata = $metadata;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMetadata($key = null)
    {
        if (!$key) {
            return $this->metadata;
        }

        if (!isset($this->metadata[$key])) {
            return null;
        }

        return $this->metadata[$key];
    }

    public function __toString()
    {
        return $this->name;
    }
}