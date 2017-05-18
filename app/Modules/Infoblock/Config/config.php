<?php

return
[
    'name' => 'Infoblock',
    'version' => '1.0',
    'date' => '2017-03-01',
    'label' => 'Инфоблоки',
    'section' =>
        [
        "bundle" => "Контент",
        "iconSmall" => "engine/app/Modules/Infoblock/Admin/images/icon_small.png",
        "iconBig" => "engine/app/Modules/Infoblock/Admin/images/icon_big.png",
        "pathToCss" => "engine/app/Modules/Infoblock/Admin/css/main.css",
        "pathToJs" => "engine/app/Modules/Infoblock/Admin/js/index.js",
        "menuLeft" => true,
        'weight' => 1
        ],
    'components' =>
        [
            [
            'nameBundle' => NULL,
            'nameComponent' => 'get',
            'labelComponent' => 'Установить',
            'pathToCss' => NULL,
            'pathToJs' => 'engine/app/Modules/Infoblock/Admin/js/component/get/js/index.js',
            ]
        ],
    'templates' =>
        [
            [
            'labelTemplate' => 'Установить',
            'htmlTpl' =>
'{if $INFOBLOCK}
    {$INFOBLOCK.html}
{/if}'
            ]
        ]
];