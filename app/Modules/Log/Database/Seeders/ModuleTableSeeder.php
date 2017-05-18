<?php
/**
 * Модуль Логирование.
 * Этот модуль содержит все классы для работы с логированием.
 * @package App.Modules.Log
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Log\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
    $module = \DB::table('module')->where('nameModule', 'Log')->first();

        if(!$module)
        {
            $idModule = \DB::table('module')->insertGetId(
                array (
                    'nameModule' => 'Log',
                    'labelModule' => 'Журнал логов',
                    'status' => 1,
                )
            );

            \DB::table('widget')->insert(array (
                    0 =>
                        array (
                            'idModule' => $idModule,
                            'actionWidget' => 'log',
                            'labelWidget' => 'Журнал логов',
                            'icon' => 'engine/app/Modules/Log/Admin/images/icon_small.png',
                            'pathToCss' => NULL,
                            'pathToJs' => 'engine/app/Modules/Log/Admin/js/widget/log/js/index.js',
                            'def' => 1,
                            'status' => 1,
                        )
                )
            );

            $idAdminSection = \DB::table('adminSection')->insertGetId(
                array (
                    'idModule' => $idModule,
                    'labelSection' => 'Журнал логов',
                    'bundle' => 'SYSTEM',
                    'iconSmall' => 'engine/app/Modules/Log/Admin/images/icon_small.png',
                    'iconBig' => 'engine/app/Modules/Log/Admin/images/icon_big.png',
                    'menuLeft' => 0,
                    'pathToCss' => 'engine/app/Modules/Log/Admin/css/main.css',
                    'pathToJs' => 'engine/app/Modules/Log/Admin/js/index.js',
                    'weight' => 1,
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
