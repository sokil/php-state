# Finite State Machine

[![Build Status](https://travis-ci.org/sokil/php-state.png?branch=master&1)](https://travis-ci.org/sokil/php-state)
[![Coverage Status](https://coveralls.io/repos/sokil/php-state/badge.png)](https://coveralls.io/r/sokil/php-state)

### Basic Usage

```php
<?php

// create state machine builder
$machineBuilder = new MachineBuilder();

// configure states
$machineBuilder
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
    });
    
// set initial state
$machineBuilder->setInitialState('new');

// configure transitions between states
$machineBuilder
    ->addTransition(function(TransitionBuilder $builder) {
        $builder
            ->setName('set_in_progress')
            ->setInitialStateName('new')
            ->setResultingStateName('in_progress')
            ->setAcceptCondition(function() {
                // conditions when accepted to transit from "new" state to "in_progress"
                return true;
            });
    })
    ->addTransition(function(TransitionBuilder $builder) {
        $builder
            ->setName('set_done')
            ->setInitialStateName('in_progress')
            ->setResultingStateName('done');
    });
    
// create machine
$machine = $machineBuilder->getMachine();

// process transition
$state = $machine->process('set_in_progress')->getCurrentState();
```

### Installation

You can install library through Composer:

{
    "require": {
        "sokil/php-state": "dev-master"
    }
}
