<?php

namespace Sokil\State;

class StateBuilder
{
    private $name;

    /**
     * @param $name
     * @return StateBuilder
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getState()
    {
        return new State($this->name);
    }
}