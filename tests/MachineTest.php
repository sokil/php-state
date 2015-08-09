<?php

namespace Sokil\State;

class MachineTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $machineBuilder = new MachineBuilder();
        $state = $machineBuilder
            ->addState(function(StateBuilder $builder) {
                $builder->setName('new');
            })
            ->addState(function(StateBuilder $builder) {
                $builder
                    ->setName('in_progress')
                    ->setMetadata([
                        'label' => 'In progress'
                    ]);
            })
            ->addState(function(StateBuilder $builder) {
                $builder->setName('done');
            })
            ->setInitialState('new')
            ->addTransition(function(TransitionBuilder $builder) {
                $builder
                    ->setName('set_in_progress')
                    ->setInitialStateName('new')
                    ->setResultingStateName('in_progress');
            })
            ->addTransition(function(TransitionBuilder $builder) {
                $builder
                    ->setName('mark_done')
                    ->setInitialStateName('in_progress')
                    ->setResultingStateName('done');
            })
            ->getMachine()
            ->process('set_in_progress')
            ->getCurrentState();

        $this->assertEquals('in_progress', $state->getName());
        $this->assertEquals(['label' => 'In progress'], $state->getMetadata());
        $this->assertEquals('In progress', $state->getMetadata('label'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Initial state not specified
     */
    public function testProcess_InitialStateNotSpecified()
    {
        $machineBuilder = new MachineBuilder();
        $machine = $machineBuilder->getMachine();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Passed name of initial state is wrong
     */
    public function testProcess_PassedNameOfCurrentStateIsWrong()
    {
        $machineBuilder = new MachineBuilder();
        $machine = $machineBuilder
            ->setInitialState('new')
            ->getMachine();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong transition name
     */
    public function testProcess_UnexistedTransition()
    {
        $machineBuilder = new MachineBuilder();
        $machine = $machineBuilder
            ->addState(function(StateBuilder $builder) {
                $builder->setName('new');
            })
            ->addState(function(StateBuilder $builder) {
                $builder->setName('resolved');
            })
            ->setInitialState('new')
            ->addTransition(function(TransitionBuilder $builder) {
                $builder
                    ->setInitialStateName('new')
                    ->setResultingStateName('resolved');
            })
            ->getMachine();

        $machine->process('UNEXISTED_TRANSITION');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No transitions found for passed state
     */
    public function testGetNextTransitions_NoTransitionsFoundForPassedState()
    {
        $machineBuilder = new MachineBuilder();
        $machine = $machineBuilder
            ->addState(function(StateBuilder $builder) {
                $builder->setName('new');
            })
            ->setInitialState('new')
            ->getMachine()
            ->getNextTransitions();
    }

    public function testSetCondition()
    {
        $machineBuilder = new MachineBuilder();
        $nextStates = $machineBuilder
            ->addState(function(StateBuilder $builder) {
                $builder->setName('new');
            })
            ->addState(function(StateBuilder $builder) {
                $builder->setName('in_progress');
            })
            ->addState(function(StateBuilder $builder) {
                $builder->setName('rejected');
            })
            ->addState(function(StateBuilder $builder) {
                $builder->setName('closed');
            })
            ->setInitialState('new')
            ->addTransition(function(TransitionBuilder $builder) {
                $builder
                    ->setName('set_in_progress')
                    ->setInitialStateName('new')
                    ->setResultingStateName('in_progress')
                    ->setAcceptCondition(function() { return true; });
            })
            ->addTransition(function(TransitionBuilder $builder) {
                $builder
                    ->setName('set_rejected')
                    ->setInitialStateName('new')
                    ->setResultingStateName('rejected')
                    ->setAcceptCondition(function() { return false; });
            })
            ->addTransition(function(TransitionBuilder $builder) {
                $builder
                    ->setName('set_closed')
                    ->setInitialStateName('new')
                    ->setResultingStateName('closed');
            })
            ->getMachine()
            ->getNextStates();

        // test keys
        $this->assertEquals(['set_in_progress', 'set_closed'], array_keys($nextStates));

        // test values
        $this->assertEquals('in_progress', $nextStates['set_in_progress']->getName());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Passed name of current state is wrong
     */
    public function testInitialize_WrongStateName()
    {
        $machineBuilder = new MachineBuilder();

        $machine = $machineBuilder
            ->addState(function(StateBuilder $builder) {
                $builder->setName('new');
            })
            ->setInitialState('new')
            ->getMachine()
            ->initialize('resolved');
    }
}
