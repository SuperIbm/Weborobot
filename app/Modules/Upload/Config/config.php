<?php

return
[
'name' => 'Upload',
'version' => '1.0',
'date' => '2017-03-01',
'label' => 'Обновления',
    'section' =>
    [
    "bundle" => "Система",
    "iconSmall" => "engine/app/Modules/Upload/Admin/images/icon_small.png",
    "iconBig" => "engine/app/Modules/Upload/Admin/images/icon_big.png",
    "pathToCss" => "engine/app/Modules/Upload/Admin/css/main.css",
    "pathToJs" => "engine/app/Modules/Upload/Admin/js/index.js",
    "menuLeft" => false,
    'weight' => 2
    ],
    'widgets' =>
    [
        [
        'actionWidget' => 'upload',
        'labelWidget' => 'Обновления',
        'icon' => 'engine/app/Modules/Upload/Admin/images/icon_small.png',
        'pathToCss' => NULL,
        'pathToJs' => 'engine/app/Modules/Upload/Admin/js/widget/upload/js/index.js',
        'def' => "Да"
        ]
    ]
];