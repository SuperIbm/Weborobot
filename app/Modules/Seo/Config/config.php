<?php

return [
'name' => 'Seo',
'version' => '1.0',
'date' => '2017-03-01',
'label' => 'Статистика посещения',
    'section' =>
    [
    "bundle" => "Продвижение",
    "iconSmall" => "app/Modules/Seo/Admin/images/icon_small.png",
    "iconBig" => "app/Modules/Seo/Admin/images/icon_big.png",
    "pathToCss" => "app/Modules/Seo/Admin/css/main.css",
    "pathToJs" => "app/Modules/Seo/Admin/js/index.js",
    "menuLeft" => false,
    'weight' => 0
    ],
    'components' =>
    [
        [
        'controller' => 'SeoController',
        'nameComponent' => 'get',
        'labelComponent' => 'Установить',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/Seo/Admin/js/component/get/js/index.js',
        ]
    ],
    'widgets' =>
    [
        [
        'actionWidget' => 'seo',
        'labelWidget' => 'Статистика посещения',
        'icon' => 'app/Modules/Seo/Admin/images/icon_small.png',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/Seo/Admin/js/widget/seo/js/index.js',
        'def' => "Да"
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Место для храненя статистики
    |--------------------------------------------------------------------------
    |
    | Здесь можно определить место для хранения статистики сайта. Допустимые
    | значения: "mongodb" - Mongodb, "database" - База данных.
    |
    */
    'driver' => env('SEO_DRIVER', 'mongodb')
];
