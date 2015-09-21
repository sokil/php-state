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

    /**
     * @var array Transition metadata
     */
    private $metadata;

    public function __construct($name, $initialState, $resultingState, callable $acceptConditionCallable = null, array $metadata = [])
    {
        $this->name = $name;
        $this->initialStateName = $initialState;
        $this->resultingStateName = $resultingState;
        $this->acceptConditionCallable = $acceptConditionCallable;
        $this->metadata = $metadata;
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
