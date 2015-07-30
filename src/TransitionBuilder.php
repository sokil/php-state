<?php

namespace Sokil\State;

class TransitionBuilder
{
    private $name;

    /**
     * @var State
     */
    private $initialState;

    /**
     * @var State
     */
    private $resultingState;

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return TransitionBuilder
     */
    public function setInitialState($state)
    {
        $this->initialState = $state;
        return $this;
    }

    /**
     * @return TransitionBuilder
     */
    public function setResultingState($state)
    {
        $this->resultingState = $state;
        return $this;
    }

    /**
     * @return Transition
     */
    public function getTransition()
    {
        return new Transition(
            $this->name,
            $this->initialState,
            $this->resultingState
        );
    }
}