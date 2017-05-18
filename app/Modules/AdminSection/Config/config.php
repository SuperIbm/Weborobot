<?php
return
[
'name' => 'AdminSection',
'version' => '1.0',
'date' => '2017-03-01',
'label' => 'Разделы',
    'section' =>
    [
    "bundle" => "Управление",
    "iconSmall" => "app/Modules/AdminSection/Admin/images/icon_small.png",
    "iconBig" => "app/Modules/AdminSection/Admin/images/icon_big.png",
    "pathToCss" => "app/Modules/AdminSection/Admin/css/main.css",
    "pathToJs" => "app/Modules/AdminSection/Admin/js/index.js",
    "menuLeft" => false,
    'weight' => 3
    ],
    'bundles' =>
    [
    'CONTENT' => 'Контент',
    'SERVICES' => 'Сервисы',
    'SALES' => 'Продажи',
    'MANEGER' => 'Управление',
    'SEO' => 'Продвижение',
    'SYSTEM' => 'Система'
    ]
];