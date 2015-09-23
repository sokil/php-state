# Finite State Machine

Implementation of finite state machine on PHP, based on immutable objects.

[![Latest Stable Version](https://poser.pugx.org/sokil/php-state/v/stable.png)](https://packagist.org/packages/sokil/php-state)
[![Total Downloads](http://img.shields.io/packagist/dt/sokil/php-state.svg)](https://packagist.org/packages/sokil/php-state)
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

```json
{
    "require": {
        "sokil/php-state": "dev-master"
    }
}
```

### Configuration

Machine may be configured directly in code, as in sample above. But also it may be configured by using configuration in files of different formats. Currenly supported are YAML, JSON and php array files. Exaples of configs may be viewed [here](https://github.com/sokil/php-state/tree/master/tests/configs).

In common case structure of config is:
```yaml
stateName1:
  initial: true
  transitions:
    transition1Name:
      resultingState: stateName2
    to_rejected:
      resultingState: stateName3

stateName2:
  transitions:
  ...
```

```php
<?php

// YAML
$configuration = new YamlConfiguration('config'.yaml');

// PHP Array
$configuration = new ArrayConfiguration('config.php');

// JSON
$configuration = new JsonConfiguration('config'.json');

// Configure
$machineBuilder = new MachineBuilder();
$machine = $machineBuilder->configure($configuration)->getMachine();
```

By default, `YamlConfiguration` uses pecl extension, but if there is no possibility to install this extension on server, you can use
[Symfony's YAML component](http://symfony.com/doc/current/components/yaml/introduction.html).

```php
<?php
$configuration = new YamlConfiguration('config.yaml', ['pecl' => false]);
```

This also require you to add dependency on `symfony/yaml` to your `composer.json`.
