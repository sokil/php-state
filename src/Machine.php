<?php

namespace Sokil\State;

class Machine
{
    /**
     * @var State Current state
     */
    private $currentState;

    /**
     * @var array List of states
     */
    private $states = [];

    /**
     * @var array List of transitions
     */
    private $transitions = [];

    public function __construct(array $states, $currentStateName, array $transitions)
    {
        $this->states = $states;

        $this->transitions = $transitions;

        $this->currentState = $this->states[$currentStateName];
    }

    /**
     * Get current state
     * @return State
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * Process transition from initial to resulting state
     * @param $transitionName
     * @return Machine
     */
    public function process($transitionName)
    {
        /* @var $transition \Sokil\State\Transition */

        $transitions = $this->transitions[$this->currentState->getName()];
        if (empty($transitions[$transitionName])) {
            throw new \InvalidArgumentException('Wrong transition name');
        }

        // get transition
        $transition = $transitions[$transitionName];

        // set current state
        $this->currentState = $this->states[$transition->getResultingState()];

        return $this;
    }
}