<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default ParcelTrap Driver Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the ParcelTrap drivers below you wish
    | to use as your default connection for all parcel work. Of course
    | you may use many drivers at once using the ParcelTrap library.
    |
    */

    'default' => env('PARCELTRAP_DEFAULT_DRIVER'),

    /*
    |--------------------------------------------------------------------------
    | ParcelTrap Drivers
    |--------------------------------------------------------------------------
    |
    | Here are each of the ParcelTrap drivers setup for your application.
    |
    */

    'drivers' => [

        // 'royal_mail' => [
        //     'client_id' => env('PARCELTRAP_ROYAL_MAIL_CLIENT_ID'),
        //     'client_secret' => env('PARCELTRAP_ROYAL_MAIL_CLIENT_SECRET'),
        //     'accept_terms' => env('PARCELTRAP_ROYAL_MAIL_ACCEPT_TERMS', true),
        //     'driver' => ParcelTrap\RoyalMail\RoyalMail::class,
        // ],

    ],

];
