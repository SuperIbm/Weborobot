<?php
/**
 * Модуль Robots.
 * Этот модуль содержит все классы для работы с Robots.
 * @package App.Modules.Robots
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Robots\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'Robots')->first();

        if(!$module)
        {
            $idModule = \DB::table('module')->insertGetId(
                array (
                    'nameModule' => 'Robots',
                    'labelModule' => 'Robots',
                    'status' => 1,
                )
            );

            $idAdminSection = \DB::table('adminSection')->insertGetId(
                array (
                    'idModule' => $idModule,
                    'labelSection' => 'Robots',
                    'bundle' => 'SEO',
                    'iconSmall' => 'engine/app/Modules/Robots/Admin/images/icon_small.png',
                    'iconBig' => 'engine/app/Modules/Robots/Admin/images/icon_big.png',
                    'menuLeft' => 0,
                    'pathToCss' => 'engine/app/Modules/Robots/Admin/css/main.css',
                    'pathToJs' => 'engine/app/Modules/Robots/Admin/js/index.js',
                    'weight' => 2,
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
