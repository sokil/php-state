<?php

namespace Sokil\State;

class MachineBuilder
{
    /**
     * @var array List of states
     */
    private $states = [];

    private $transitions = [];

    private $initialStateName;

    /**
     * Add new state
     * @param State $state
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
     * @param Transition $transition
     * @return MachineBuilder
     */
    public function addTransition(callable $transitionBuilderCallable)
    {
        $transitionBuilder = new TransitionBuilder();
        call_user_func($transitionBuilderCallable, $transitionBuilder);
        $transition = $transitionBuilder->getTransition();

        $this->transitions[$transition->getInitialState()][$transition->getName()] = $transition;
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
