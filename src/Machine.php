<?php

namespace Sokil\State;

class Machine
{
    /**
     * @var State Current state
     */
    private $currentState;

    /**
     * @var array<stateName => State> List of states
     */
    private $states = [];

    /**
     * @var array<initialStateName => array<transitionName => Transition>> List of transition instances
     */
    private $transitions = [];

    /**
     * @param array<State> $states List of state instances
     * @param string $currentStateName name of current state
     * @param array<initialStateName => array<transitionName => Transition>> $transitions list of transition instances
     */
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

    public function getNextStates()
    {
        /* @var $transition \Sokil\State\Transition */

        $nextStates = [];

        foreach ($this->transitions[$this->currentState->getName()] as $transitionName => $transition) {
            if (!$transition->isAcceptable()) {
                continue;
            }

            $nextStates[$transitionName] = $this->states[$transition->getResultingStateName()];
        }

        return $nextStates;
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
        $this->currentState = $this->states[$transition->getResultingStateName()];

        return $this;
    }
}