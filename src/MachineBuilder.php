<?php

namespace Sokil\State;

class MachineBuilder
{
    /**
     * @var array<stateName => State> List of state instances
     */
    private $states = [];

    /**
     * @var array<initialStateName => array<transitionName => Transition>> List of transition instances
     */
    private $transitions = [];

    /**
     * @var string name of initial state
     */
    private $initialStateName;

    /**
     * Add new state
     * @param callable $stateBuilderCallable
     * @return MachineBuilder
     */
    public function addState(callable $stateBuilderCallable)
    {
        $stateBuilder = new StateBuilder();
        call_user_func($stateBuilderCallable, $stateBuilder, $this);
        $state = $stateBuilder->getState();

        $this->states[$state->getName()] = $state;

        return $this;
    }

    /**
     * @param $stateName
     * @return MachineBuilder
     */
    public function setInitialState($stateName)
    {
        $this->initialStateName = $stateName;
        return $this;
    }

    /**
     * Add new transition
     * @param callable $transitionBuilderCallable
     * @return MachineBuilder
     */
    public function addTransition(callable $transitionBuilderCallable)
    {
        $transitionBuilder = new TransitionBuilder();
        call_user_func($transitionBuilderCallable, $transitionBuilder);
        $transition = $transitionBuilder->getTransition();

        $this->transitions[$transition->getInitialStateName()][$transition->getName()] = $transition;
        return $this;
    }

    /**
     * @return Machine
     */
    public function getMachine()
    {
        return new Machine($this->states, $this->initialStateName, $this->transitions);
    }
}
