<?php

$lang = app()->getLocale();
return [
    'sy' => [
        'phone' => '+963932474474',
        'email' => 'info@azalea.com' ,
        "store_location" => $lang == 'en' ? 'Abou Rmaneh' : 'أبو رمانة' ,
        'location' => 'sy',
    ],
    'others' => [
        'phone' => '+36704228484',
        'email' => 'info@azalea.com',
        "store_location" => $lang == 'en' ? '7-8 ERSZBET TER' : 'هنغاريا' ,
        'postcode' => '1051 Budapest, Hungary',
        'location' => 'others',
    ]
];
