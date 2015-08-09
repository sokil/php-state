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

    private $initialStateName;

    /**
     * @param array<State> $states List of state instances
     * @param array<initialStateName => array<transitionName => Transition>> $transitions list of transition instances
     * @param string $initialStateName name of initial state
     */
    public function __construct(array $states, array $transitions, $initialStateName)
    {
        $this->states = $states;
        $this->transitions = $transitions;

        $this->setInitialState($initialStateName);
    }

    public function setInitialState($stateName)
    {
        if (empty($this->states[$stateName])) {
            throw new \Exception('Passed name of initial state is wrong');
        }

        $this->initialStateName = $stateName;

        return $this;
    }

    /**
     * Initialize machine by current state.
     * @param $stateName state name that will set as current. If omited, then
     *   initial state will be set as current
     * @return Machine
     * @throws \Exception
     */
    public function initialize($stateName = null)
    {
        if (!$stateName) {
            $stateName = $this->initialStateName;
        }

        if (empty($this->states[$stateName])) {
            throw new \Exception('Passed name of current state is wrong');
        }

        $this->currentState = $this->states[$stateName];

        return $this;
    }

    /**
     * Get current state
     * @return State
     */
    public function getCurrentState()
    {
        if(!$this->currentState) {
            $this->initialize();
        }

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
        $currentStateName = $this->getCurrentState()->getName();
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