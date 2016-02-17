<?php
return [
    'version' => '3.5',

    'formatter' => [
        'decimals' => 0,
        'decimal_seperator' => ',',
        'thousand_seperator' => '.',
        'currency' => '€',
    ],

    'restarts' => [
        '02:00',
        '08:00',
        '14:00',
        '20:00',
    ],

    'lotto' => [
        'cost' => 25000,
        'draw' => [
            'day' => \Carbon\Carbon::FRIDAY,
            'new' => \Carbon\Carbon::MONDAY,
            'time' => '20:00',
        ],
        'jackpot' => [
            2500000,
            10000000,
        ],
        'profits' => [
            1 => 0.01,
            2 => 0.05,
            3 => 0.1,
            4 => 0.25,
            5 => 0.5,
            6 => 1,
        ],
    ],
];