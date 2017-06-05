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
    "iconSmall" => "app/Modules/User/Admin/images/icon_small.png",
    "iconBig" => "app/Modules/User/Admin/images/icon_big.png",
    "pathToCss" => "app/Modules/User/Admin/css/main.css",
    "pathToJs" => "app/Modules/User/Admin/js/index.js",
    "menuLeft" => true,
    'weight' => 0
    ],
    'components' =>
    [
        [
        'controller' => 'UserController',
        'nameComponent' => 'siteLogin',
        'labelComponent' => 'Авторизация',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/User/Admin/js/component/siteLogin/js/index.js',
        ],
        [
        'controller' => 'UserController',
        'nameComponent' => 'siteCreate',
        'labelComponent' => 'Регистрация',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/User/Admin/js/component/siteCreate/js/index.js',
        ],
        [
        'controller' => 'UserController',
        'nameComponent' => 'siteForget',
        'labelComponent' => 'Восстановления пароля',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/User/Admin/js/component/siteForget/js/index.js',
        ],
        [
        'controller' => 'UserController',
        'nameComponent' => 'siteUpdate',
        'labelComponent' => 'Изменение данных',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/User/Admin/js/component/siteUpdate/js/index.js',
        ],
        [
        'controller' => 'UserController',
        'nameComponent' => 'siteConfirm',
        'labelComponent' => 'Подтверждение учетной записи',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/User/Admin/js/component/siteConfirm/js/index.js',
        ],
        [
        'controller' => 'UserController',
        'nameComponent' => 'siteRead',
        'labelComponent' => 'Информация о текущем пользователе',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/User/Admin/js/component/siteRead/js/index.js',
        ],
        [
        'controller' => 'UserController',
        'nameComponent' => 'siteExit',
        'labelComponent' => 'Выход',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/User/Admin/js/component/siteExit/js/index.js',
        ]
    ]
];