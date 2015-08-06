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
                    ->setInitialState('new')
                    ->setResultingState('in_progress');
            })
            ->addTransition(function(TransitionBuilder $builder) {
                $builder
                    ->setName('mark_done')
                    ->setInitialState('in_progress')
                    ->setResultingState('done');
            })
            ->getMachine()
            ->process('set_in_progress')
            ->getCurrentState();

        $this->assertEquals('in_progress', $state->getName());
        $this->assertEquals(['label' => 'In progress'], $state->getMetadata());
        $this->assertEquals('In progress', $state->getMetadata('label'));
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
            ->setInitialState('new')
            ->addTransition(function(TransitionBuilder $builder) {
                $builder
                    ->setName('set_in_progress')
                    ->setInitialState('new')
                    ->setResultingState('in_progress')
                    ->setAcceptCondition(function() { return true; });
            })
            ->addTransition(function(TransitionBuilder $builder) {
                $builder
                    ->setName('set_rejected')
                    ->setInitialState('new')
                    ->setResultingState('rejected')
                    ->setAcceptCondition(function() { return false; });
            })
            ->getMachine()
            ->getNextStates();

        // test keys
        $this->assertEquals(['set_in_progress'], array_keys($nextStates));

        // test values
        $this->assertEquals('in_progress', $nextStates['set_in_progress']->getName());
    }
}
