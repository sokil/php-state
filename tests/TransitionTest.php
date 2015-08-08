<?php

namespace Sokil\State;

class TransitionTest extends \PHPUnit_Framework_TestCase
{
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
