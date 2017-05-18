<?php
/**
 * Модуль Шаблоны для страниц.
 * Этот модуль содержит все классы для работы с шаблонами для страниц.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageTemplate\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'PageTemplate')->first();

        if(!$module)
        {
            $idModule = \DB::table('module')->insertGetId(
                array (
                    'nameModule' => 'PageTemplate',
                    'labelModule' => 'Шаблоны страниц',
                    'status' => 1,
                )
            );

            $idAdminSection = \DB::table('adminSection')->insertGetId(
                array (
                    'idModule' => $idModule,
                    'labelSection' => 'Шаблоны страниц',
                    'bundle' => 'MANEGER',
                    'iconSmall' => 'engine/app/Modules/PageTemplate/Admin/images/icon_small.png',
                    'iconBig' => 'engine/app/Modules/PageTemplate/Admin/images/icon_big.png',
                    'menuLeft' => 0,
                    'pathToCss' => 'engine/app/Modules/PageTemplate/Admin/css/main.css',
                    'pathToJs' => 'engine/app/Modules/PageTemplate/Admin/js/index.js',
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
