<?php

namespace Sokil\State;

use Sokil\State\Configuration\YamlConfiguration;
use Sokil\State\Configuration\ArrayConfiguration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function configurationsProvider()
    {
        return [
            [new YamlConfiguration(__DIR__ . '/configs/task.yaml')],
            [new ArrayConfiguration(__DIR__ . '/configs/task.php')],
        ];
    }

    /**
     * @dataProvider configurationsProvider
     */
    public function testConfigure($configuration)
    {
        $machineBuilder = new MachineBuilder();
        $machine = $machineBuilder->configure($configuration)->getMachine();

        $this->assertEquals([
            'to_in_progress',
            'to_rejected',
        ], array_keys($machine->getNextStates()));

        $this->assertEquals([
            'to_in_progress',
            'to_rejected',
        ], array_keys($machine->getNextTransitions()));
    }
}