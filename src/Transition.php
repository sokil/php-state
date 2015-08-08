<?php

namespace Sokil\State;

class Transition
{
    private $name;

    /**
     * @var string
     */
    private $initialStateName;

    /**
     * @var string
     */
    private $resultingStateName;

    /**
     * @var callable which checks if transition acceptable
     */
    private $acceptConditionCallable;

    public function __construct($name, $initialState, $resultingState, $acceptConditionCallable = null)
    {
        $this->name = $name;
        $this->initialStateName = $initialState;
        $this->resultingStateName = $resultingState;
        $this->acceptConditionCallable = $acceptConditionCallable;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getInitialStateName()
    {
        return $this->initialStateName;
    }

    /**
     * @return string
     */
    public function getResultingStateName()
    {
        return $this->resultingStateName;
    }

    public function isAcceptable()
    {
        if (!$this->acceptConditionCallable) {
            return true;
        }

        return call_user_func($this->acceptConditionCallable);
    }

    public function __toString()
    {
        return $this->name;
    }
}