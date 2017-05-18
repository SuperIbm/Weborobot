<?php

return
[
'name' => 'User',
'version' => '1.0',
'date' => '2017-03-01',
'label' => 'Пользователи',
    'section' =>
    [
    "bundle" => "Управление",
    "iconSmall" => "engine/app/Modules/User/Admin/images/icon_small.png",
    "iconBig" => "engine/app/Modules/User/Admin/images/icon_big.png",
    "pathToCss" => "engine/app/Modules/User/Admin/css/main.css",
    "pathToJs" => "engine/app/Modules/User/Admin/js/index.js",
    "menuLeft" => true,
    'weight' => 0
    ],
    'components' =>
    [
        [
        'nameBundle' => NULL,
        'nameComponent' => 'siteLogin',
        'labelComponent' => 'Авторизация',
        'pathToCss' => NULL,
        'pathToJs' => 'engine/app/Modules/User/Admin/js/component/siteLogin/js/index.js',
        ],
        [
        'nameBundle' => NULL,
        'nameComponent' => 'siteCreate',
        'labelComponent' => 'Регистрация',
        'pathToCss' => NULL,
        'pathToJs' => 'engine/app/Modules/User/Admin/js/component/siteCreate/js/index.js',
        ],
        [
        'nameBundle' => NULL,
        'nameComponent' => 'siteForget',
        'labelComponent' => 'Восстановления пароля',
        'pathToCss' => NULL,
        'pathToJs' => 'engine/app/Modules/User/Admin/js/component/siteForget/js/index.js',
        ],
        [
        'nameBundle' => NULL,
        'nameComponent' => 'siteUpdate',
        'labelComponent' => 'Изменение данных',
        'pathToCss' => NULL,
        'pathToJs' => 'engine/app/Modules/User/Admin/js/component/siteUpdate/js/index.js',
        ],
        [
        'nameBundle' => NULL,
        'nameComponent' => 'siteConfirm',
        'labelComponent' => 'Подтверждение учетной записи',
        'pathToCss' => NULL,
        'pathToJs' => 'engine/app/Modules/User/Admin/js/component/siteConfirm/js/index.js',
        ],
        [
        'nameBundle' => NULL,
        'nameComponent' => 'siteRead',
        'labelComponent' => 'Информация о текущем пользователе',
        'pathToCss' => NULL,
        'pathToJs' => 'engine/app/Modules/User/Admin/js/component/siteRead/js/index.js',
        ],
        [
        'nameBundle' => NULL,
        'nameComponent' => 'siteExit',
        'labelComponent' => 'Выход',
        'pathToCss' => NULL,
        'pathToJs' => 'engine/app/Modules/User/Admin/js/component/siteExit/js/index.js',
        ]
    ]
];