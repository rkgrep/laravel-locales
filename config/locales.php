<?php

return [

    /*
     * Default locale driver.
     * Currently available: config, database, eloquent
     */
    'driver' => 'config',

    /*
     * List of locales for config driver
     */
    'list' => [
        'en' => [
            'locales' => ['en', 'en_US', 'en-US', 'en-us', 'eng', 'English', 1033],
            'names' => [
                'native' => 'English',
                'i18n' => 'English (US)'
            ],
        ]
    ],

    /*
     * Table used for database driver
     */
    'table' => 'locales',

    /**
     * Model class used for eloquent driver
     */
    'model' => \rkgrep\Locales\EloquentLocale::class,
];
