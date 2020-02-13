<?php

namespace Sokil\State;

use Sokil\State\Configuration\YamlConfiguration;
use Sokil\State\Configuration\ArrayConfiguration;
use Sokil\State\Configuration\JsonConfiguration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function configurationsProvider()
    {
        return [
            [new YamlConfiguration(__DIR__ . '/configs/task.yaml', ['pecl' => false])],
            [new YamlConfiguration(__DIR__ . '/configs/task.yaml', ['pecl' => true])],
            [new ArrayConfiguration(__DIR__ . '/configs/task.php')],
            [new JsonConfiguration(__DIR__ . '/configs/task.json')],
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
