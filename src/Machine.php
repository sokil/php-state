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

        if(!$currentStateName) {
            throw new \Exception('Current state not set');
        }

        if (empty($this->states[$currentStateName])) {
            throw new \Exception('Passed name of current state is wrong');
        }

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
     * Get next transitions
     * @return array
     * @throws \Exception
     */
    public function getNextTransitions()
    {
        /* @var $transition \Sokil\State\Transition */

        $nextTransitions = [];

        // get all transitions
        $currentStateName = $this->currentState->getName();
        if (empty($this->transitions[$currentStateName])) {
            throw new \Exception('No transitions found for passed state');
        }

        // get accepted transitions
        foreach ($this->transitions[$currentStateName] as $transitionName => $transition) {
            if (!$transition->isAcceptable()) {
                continue;
            }

            $nextTransitions[$transitionName] = $transition;
        }

        return $nextTransitions;
    }

    /**
     * Get next states
     * @return array
     * @throws \Exception
     */
    public function getNextStates()
    {
        return array_map(
            function(Transition $transition) {
                return $this->states[$transition->getResultingStateName()];
            },
            $this->getNextTransitions()
        );
    }

    /**
     * Process transition from initial to resulting state
     * @param $transitionName
     * @return Machine
     */
    public function process($transitionName)
    {
        /* @var $transition \Sokil\State\Transition */

        // get transition
        $transitions = $this->getNextTransitions();
        if (empty($transitions[$transitionName])) {
            throw new \InvalidArgumentException('Wrong transition name');
        }

        $transition = $transitions[$transitionName];

        // set current state
        $this->currentState = $this->states[$transition->getResultingStateName()];

        return $this;
    }
}