<?php

namespace Sokil\State;

class StateTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMetadata()
    {
        $state = new State('stateName', [
            'param1' => 'value1',
            'param2' => 'value2',
        ]);

        $this->assertEquals([
            'param1' => 'value1',
            'param2' => 'value2',
        ], $state->getMetadata());

        $this->assertEquals('value1', $state->getMetadata('param1'));
        $this->assertEquals('value2', $state->getMetadata('param2'));

        $this->assertEquals(null, $state->getMetadata('UNEXISTED_KEY'));
    }

    public function testToString()
    {
        $state = new State('someStateName', ['key' => 'val']);
        $this->assertEquals('someStateName', (string) $state);
    }
}
