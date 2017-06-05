<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'Seo')->first();

        if(!$module)
        {
            $idModule = \DB::table('module')->insertGetId(
                array (
                    'nameModule' => 'Seo',
                    'labelModule' => 'Статистика посещения',
                    'status' => 1,
                )
            );

            \DB::table('component')->insert(array (
                    0 =>
                        array (
                            'idModule' => $idModule,
                            'controller' => 'SeoController',
                            'nameComponent' => 'get',
                            'labelComponent' => 'Установить',
                            'pathToCss' => NULL,
                            'pathToJs' => 'app/Modules/Seo/Admin/js/component/get/js/index.js',
                            'status' => 1
                        )
                )
            );

            \DB::table('widget')->insert(array (
                    0 =>
                        array (
                            'idModule' => $idModule,
                            'actionWidget' => 'seo',
                            'labelWidget' => 'Статистика посещения',
                            'icon' => 'app/Modules/Seo/Admin/images/icon_small.png',
                            'pathToCss' => '',
                            'pathToJs' => 'app/Modules/Seo/Admin/js/widget/seo/js/index.js',
                            'def' => 1,
                            'status' => 1,
                        )
                )
            );

            $idAdminSection = \DB::table('adminSection')->insertGetId(
                array (
                    'idModule' => $idModule,
                    'labelSection' => 'Статистика посещения',
                    'bundle' => 'SEO',
                    'iconSmall' => 'app/Modules/Seo/Admin/images/icon_small.png',
                    'iconBig' => 'app/Modules/Seo/Admin/images/icon_big.png',
                    'menuLeft' => 0,
                    'pathToCss' => 'app/Modules/Seo/Admin/css/main.css',
                    'pathToJs' => 'app/Modules/Seo/Admin/js/index.js',
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
