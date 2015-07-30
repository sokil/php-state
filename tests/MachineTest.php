<?php

namespace Sokil\State;

class MachineTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialize()
    {
        $machineBuilder = new MachineBuilder();
        $stateName = $machineBuilder
            ->addState(function(StateBuilder $builder) {
                $builder->setName('new');
            })
            ->addState(function(StateBuilder $builder) {
                $builder->setName('in_progress');
            })
            ->addState(function(StateBuilder $builder) {
                $builder->setName('done');
            })
            ->setInitialState('new')
            ->addTransition(function(TransitionBuilder $builder) {
                $builder
                    ->setName('take_in_progress')
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
            ->process('take_in_progress')
            ->getCurrentState()
            ->getName();

        $this->assertEquals('in_progress', $stateName);
    }
}