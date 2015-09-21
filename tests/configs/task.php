<?php

return [
    'new' => [
        'label' => 'task_status_new',
        'initial' => true,
        'transitions' => [
            'to_in_progress' => [
                'resultingState' => 'in_progress',
                'label' => 'task_transiotion_open',
                'icon' => 'glyphicon glyphicon-play',
            ],
            'to_rejected' => [
                'resultingState' => 'rejected',
                'label' => 'task_transiotion_reject',
                'icon' => 'glyphicon glyphicon-ban-circle',
            ],
        ],
    ],
    'in_progress' => [
        'label' => 'task_status_in_progress',
        'transitions' => [
            'to_resolved' => [
                'resultingState' => 'resolved',
                'label' => 'task_transiotion_resolve',
                'icon' => 'glyphicon glyphicon-ok',
            ],
            'to_rejected' => [
                'resultingState' => 'rejected',
                'label' => 'task_transiotion_reject',
                'icon' => 'glyphicon glyphicon-ban-circle',
            ],
        ],
    ],
    'rejected' => [
        'label' => 'task_status_rejected',
        'transitions' => [
            'to_in_progress' => [
                'resultingState' => 'in_progress',
                'label' => 'task_transiotion_reopen',
                'icon' => 'glyphicon glyphicon-repeat',
            ],
        ],
    ],
    'resolved' => [
        'label' => 'task_status_resolved',
        'transitions' => [
            'to_in_progress' => [
                'resultingState' => 'in_progress',
                'label' => 'task_transiotion_reopen',
                'icon' => 'glyphicon glyphicon-repeat',
            ],
        ],
    ],
];
