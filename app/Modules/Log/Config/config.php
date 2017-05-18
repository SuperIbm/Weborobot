<?php

return
[
'name' => 'Log',
'version' => '1.0',
'date' => '2017-03-01',
'label' => 'Журнал логов',
    'section' =>
    [
    "bundle" => "Система",
    "iconSmall" => "engine/app/Modules/Log/Admin/images/icon_small.png",
    "iconBig" => "engine/app/Modules/Log/Admin/images/icon_big.png",
    "pathToCss" => "engine/app/Modules/Log/Admin/css/main.css",
    "pathToJs" => "engine/app/Modules/Log/Admin/js/index.js",
    "menuLeft" => false,
    'weight' => 1
    ],
    'widgets' =>
    [
    'actionWidget' => 'log',
    'labelWidget' => 'Журнал логов',
    'icon' => 'engine/app/Modules/Log/Admin/images/icon_small.png',
    'pathToCss' => NULL,
    'pathToJs' => 'engine/app/Modules/Log/Admin/js/widget/log/js/index.js',
    'def' => "Да"
    ]
];