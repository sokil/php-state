<?php

namespace Sokil\State;

class Transition
{
    private $name;

    /**
     * @var string
     */
    private $initialState;

    /**
     * @var string
     */
    private $resultingState;

    public function __construct($name, $initialState, $resultingState)
    {
        $this->name = $name;
        $this->initialState = $initialState;
        $this->resultingState = $resultingState;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getInitialState()
    {
        return $this->initialState;
    }

    /**
     * @return string
     */
    public function getResultingState()
    {
        return $this->resultingState;
    }
}