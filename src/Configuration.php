<?php

namespace Sokil\State;

abstract class Configuration
{
    /**
     * Convert configuration in mixed formats to php array
     * @return array
     */
    abstract protected function getConfig();

    public function configure(MachineBuilder $builder)
    {
        // load config
        $stateMachineConfig = $this->getConfig();

        // build state machine
        foreach($stateMachineConfig as $stateName => $stateMetadata) {
            // get transitions
            $transitions = $stateMetadata['transitions'];
            unset($stateMetadata['transitions']);

            // is initial state
            if (isset($stateMetadata['initial'])) {
                if ($stateMetadata['initial']) {
                    $builder->setInitialState($stateName);
                }
                unset($stateMetadata['initial']);
            }

            // add state
            $builder->addState(function(StateBuilder $builder) use($stateName, $stateMetadata) {
                $builder
                    ->setName($stateName)
                    ->setMetadata($stateMetadata);
            });

            // add transitions
            foreach($transitions as $transitionName => $transitionData) {
                $builder->addTransition(
                    function(TransitionBuilder $builder) use(
                        $transitionName,
                        $transitionData,
                        $stateName
                    ) {
                        $metadata = $transitionData;
                        unset($metadata['resultingState']);

                        $builder
                            ->setName($transitionName)
                            ->setInitialStateName($stateName)
                            ->setResultingStateName($transitionData['resultingState'])
                            ->setMetadata($metadata);
                    });
            }
        }
    }
}