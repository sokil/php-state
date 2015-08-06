<?php

namespace Sokil\State;

class StateBuilder
{
    /**
     * @var string State name
     */
    private $name;

    /**
     * @var array State metadata
     */
    private $metadata = [];

    /**
     * @param string $name name of transition
     * @return StateBuilder
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set state metadata
     * @param array $metadata state metadata
     * @return $this
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function getState()
    {
        return new State(
            $this->name,
            $this->metadata
        );
    }
}