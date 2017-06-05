<?php
return
[
'name' => 'Inherit',
'version' => '1.0',
'date' => '2017-03-01',
'label' => 'Унаследовать',
    'components' =>
    [
        [
        'controller' => 'InheritController',
        'nameComponent' => 'get',
        'labelComponent' => 'Получить',
        'pathToCss' => NULL,
        'pathToJs' => 'app/Modules/Inherit/Admin/js/component/get/js/index.js',
        ]
    ]
];