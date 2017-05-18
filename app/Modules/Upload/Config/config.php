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
    "iconSmall" => "app/Modules/Upload/Admin/images/icon_small.png",
    "iconBig" => "app/Modules/Upload/Admin/images/icon_big.png",
    "pathToCss" => "app/Modules/Upload/Admin/css/main.css",
    "pathToJs" => "app/Modules/Upload/Admin/js/index.js",
    "menuLeft" => false,
    'weight' => 2
    ],
    'widgets' =>
    [
        [
        'actionWidget' => 'upload',
        'labelWidget' => 'Обновления',
        'icon' => 'app/Modules/Upload/Admin/images/icon_small.png',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/Upload/Admin/js/widget/upload/js/index.js',
        'def' => "Да"
        ]
    ]
];