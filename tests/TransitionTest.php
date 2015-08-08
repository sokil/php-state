<?php

namespace Sokil\State;

class TransitionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMetadata()
    {
        $transitionBuilder = new TransitionBuilder();
        $transition = $transitionBuilder
            ->setName('transitionName')
            ->setInitialStateName('initialStateName')
            ->setResultingStateName('resultingStateName')
            ->setMetadata([
                'param1' => 'value1',
                'param2' => 'value2',
            ])
            ->getTransition();

        $this->assertEquals([
            'param1' => 'value1',
            'param2' => 'value2',
        ], $transition->getMetadata());

        $this->assertEquals('value1', $transition->getMetadata('param1'));
        $this->assertEquals('value2', $transition->getMetadata('param2'));

        $this->assertEquals(null, $transition->getMetadata('UNEXISTED_KEY'));
    }

    public function testToString()
    {
        $transition = new Transition(
            'someTransitionName',
            'initState',
            'resultState'
        );

        $this->assertEquals('someTransitionName', (string) $transition);
    }
}
