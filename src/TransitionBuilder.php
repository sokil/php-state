<?php

namespace Sokil\State;

class TransitionBuilder
{
    private $name;

    /**
     * @var string name of initial state
     */
    private $initialStateName;

    /**
     * @var string name of resulting state
     */
    private $resultingStateName;

    /**
     * @var callable
     */
    private $acceptConditionCallable;

    /**
     * @var array State metadata
     */
    private $metadata = [];

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set initial state of transition
     * @param string $stateName name of initial state
     * @return TransitionBuilder
     */
    public function setInitialStateName($stateName)
    {
        $this->initialStateName = $stateName;
        return $this;
    }

    /**
     * Set resulting state of transition
     * @param string $stateName name of resulting state
     * @return TransitionBuilder
     */
    public function setResultingStateName($stateName)
    {
        $this->resultingStateName = $stateName;
        return $this;
    }

    public function setAcceptCondition(callable $condition)
    {
        $this->acceptConditionCallable = $condition;
        return $this;
    }

    /**
     * Set metadata
     * @param array $metadata metadata
     * @return $this
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * @return Transition
     */
    public function getTransition()
    {
        return new Transition(
            $this->name,
            $this->initialStateName,
            $this->resultingStateName,
            $this->acceptConditionCallable,
            $this->metadata
        );
    }
}