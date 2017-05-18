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
        "iconSmall" => "app/Modules/Infoblock/Admin/images/icon_small.png",
        "iconBig" => "app/Modules/Infoblock/Admin/images/icon_big.png",
        "pathToCss" => "app/Modules/Infoblock/Admin/css/main.css",
        "pathToJs" => "app/Modules/Infoblock/Admin/js/index.js",
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
            'pathToJs' => 'app/Modules/Infoblock/Admin/js/component/get/js/index.js',
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