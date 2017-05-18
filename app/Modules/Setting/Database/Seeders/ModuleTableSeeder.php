<?php
/**
 * Модуль Настройки сайта.
 * Этот модуль содержит все классы для работы с настройками сайта.
 * @package App.Modules.Setting
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Setting\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'Setting')->first();

        if(!$module)
        {
            $idModule = \DB::table('module')->insertGetId(
                array (
                    'nameModule' => 'Setting',
                    'labelModule' => 'Настройки сайта',
                    'status' => 1,
                )
            );

            $idAdminSection = \DB::table('adminSection')->insertGetId(
                array (
                    'idModule' => $idModule,
                    'labelSection' => 'Настройки сайта',
                    'bundle' => 'MANEGER',
                    'iconSmall' => 'app/Modules/Setting/Admin/images/icon_small.png',
                    'iconBig' => 'app/Modules/Setting/Admin/images/icon_big.png',
                    'menuLeft' => 0,
                    'pathToCss' => 'app/Modules/Setting/Admin/css/main.css',
                    'pathToJs' => 'app/Modules/Setting/Admin/js/index.js',
                    'weight' => 4,
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
