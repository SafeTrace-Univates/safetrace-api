<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Policy Authorization Language Lines
    |--------------------------------------------------------------------------
    |
    | The messages below are used to display standardized access responses
    | in the application's policies. They support action interpolation.
    |
    */

    'responses' => [
        'deny' => [
            'view' => [
                'default'  => 'You do not have permission to view the :model.',
                'specific' => [
                    'f' => 'You do not have permission to view this :model.',
                    'm' => 'You do not have permission to view this :model.',
                ],
            ],
            'create'   => 'You do not have permission to create a :model.',
            'update'   => 'You do not have permission to update the :model.',
            'delete'   => 'You do not have permission to delete the :model.',
            'finish'   => 'You do not have permission to finish the :model.',
            'reopen'   => 'You do not have permission to reopen the :model.',
            'feedback' => 'You do not have permission to give feedback on the :model.',
            'already'  => [
                'finished' => [
                    'f' => 'You cannot finish this :model, as it has already been finished.',
                    'm' => 'You cannot finish this :model, as it has already been finished.',
                ],
            ],
        ],
        'unavailable' => [
            'update'   => 'The :model can\'t be updated.',
            'delete'   => 'The :model can\'t be deleted.',
            'finish'   => 'The :model can\'t be finished.',
            'reopen'   => 'The :model can\'t be reopened.',
            'feedback' => 'The :model can\'t receive feedback.',
        ],
    ],
];
