<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Класс наполнения начальными данными для установки модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleTableSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
    $module = \DB::table('module')->where('nameModule', 'User')->first();

        if(!$module)
        {
            $idModule = \DB::table('module')->insertGetId(
                array (
                    'nameModule' => 'User',
                    'labelModule' => 'Пользователи',
                    'status' => 1,
                )
            );

            \DB::table('component')->insert(array (
                    0 =>
                        array (
                            'idModule' => $idModule,
                            'controller' => 'UserController',
                            'nameComponent' => 'siteLogin',
                            'labelComponent' => 'Авторизация',
                            'pathToCss' => NULL,
                            'pathToJs' => 'app/Modules/User/Admin/js/component/siteLogin/js/index.js',
                            'status' => 1
                        ),
                    1 =>
                        array (
                            'idModule' => $idModule,
                            'controller' => 'UserController',
                            'nameComponent' => 'siteCreate',
                            'labelComponent' => 'Регистрация',
                            'pathToCss' => NULL,
                            'pathToJs' => 'app/Modules/User/Admin/js/component/siteCreate/js/index.js',
                            'status' => 1
                        ),
                    2 =>
                        array (
                            'idModule' => $idModule,
                            'controller' => 'UserController',
                            'nameComponent' => 'siteForget',
                            'labelComponent' => 'Восстановления пароля',
                            'pathToCss' => NULL,
                            'pathToJs' => 'app/Modules/User/Admin/js/component/siteForget/js/index.js',
                            'status' => 1
                        ),
                    3 =>
                        array (
                            'idModule' => $idModule,
                            'controller' => 'UserController',
                            'nameComponent' => 'siteUpdate',
                            'labelComponent' => 'Изменение данных',
                            'pathToCss' => NULL,
                            'pathToJs' => 'app/Modules/User/Admin/js/component/siteUpdate/js/index.js',
                            'status' => 1
                        ),
                    4 =>
                        array (
                            'idModule' => $idModule,
                            'controller' => 'UserController',
                            'nameComponent' => 'siteConfirm',
                            'labelComponent' => 'Подтверждение учетной записи',
                            'pathToCss' => NULL,
                            'pathToJs' => 'app/Modules/User/Admin/js/component/siteConfirm/js/index.js',
                            'status' => 1
                        ),
                    5 =>
                        array (
                            'idModule' => $idModule,
                            'controller' => 'UserController',
                            'nameComponent' => 'siteRead',
                            'labelComponent' => 'Информация о текущем пользователе',
                            'pathToCss' => NULL,
                            'pathToJs' => 'app/Modules/User/Admin/js/component/siteRead/js/index.js',
                            'status' => 1
                        ),
                    6 =>
                        array (
                            'idModule' => $idModule,
                            'controller' => 'UserController',
                            'nameComponent' => 'siteExit',
                            'labelComponent' => 'Выход',
                            'pathToCss' => NULL,
                            'pathToJs' => 'app/Modules/User/Admin/js/component/siteExit/js/index.js',
                            'status' => 1
                        )
                )
            );


            $idAdminSection = \DB::table('adminSection')->insertGetId(
                array (
                    'idModule' => $idModule,
                    'labelSection' => 'Пользователи',
                    'bundle' => 'MANEGER',
                    'iconSmall' => 'app/Modules/User/Admin/images/icon_small.png',
                    'iconBig' => 'app/Modules/User/Admin/images/icon_big.png',
                    'menuLeft' => 1,
                    'pathToCss' => 'app/Modules/User/Admin/css/main.css',
                    'pathToJs' => 'app/Modules/User/Admin/js/index.js',
                    'weight' => 0,
                    'status' => 1,
                )
            );

            \DB::table('userRoleAdminSection')->insert(array (
                0 =>
                    array (
                        'idUserRole' => 1,
                        'idAdminSection' => $idAdminSection,
                        'isRead' => 1,
                        'isUpdate' => 1,
                        'isCreate' => 1,
                        'isDestroy' => 1,
                    )
            ));

            \DB::table('userRoleAdminSection')->insert(array (
                0 =>
                    array (
                        'idUserRole' => 2,
                        'idAdminSection' => $idAdminSection,
                        'isRead' => 1,
                        'isUpdate' => 1,
                        'isCreate' => 1,
                        'isDestroy' => 0,
                    )
            ));
        }
    }
}
