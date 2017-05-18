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
    "iconSmall" => "app/Modules/Log/Admin/images/icon_small.png",
    "iconBig" => "app/Modules/Log/Admin/images/icon_big.png",
    "pathToCss" => "app/Modules/Log/Admin/css/main.css",
    "pathToJs" => "app/Modules/Log/Admin/js/index.js",
    "menuLeft" => false,
    'weight' => 1
    ],
    'widgets' =>
    [
    'actionWidget' => 'log',
    'labelWidget' => 'Журнал логов',
    'icon' => 'app/Modules/Log/Admin/images/icon_small.png',
    'pathToCss' => NULL,
    'pathToJs' => 'app/Modules/Log/Admin/js/widget/log/js/index.js',
    'def' => "Да"
    ]
];