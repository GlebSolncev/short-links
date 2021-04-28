<?php

/**
 *  list short link modules
 */
return [
    'default' => 'default',

    'list' => [
        'default' =>[
            'register' => \App\Foundation\ShortLinks\DefaultShortLinks\Providers\DefaultShortLinkProvider::class
        ]
    ],
];