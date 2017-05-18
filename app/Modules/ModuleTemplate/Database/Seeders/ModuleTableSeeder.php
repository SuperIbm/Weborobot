<?php
/**
 * Модуль Шаблоны модуля.
 * Этот модуль содержит все классы для работы с шаблонами модулей системы.
 * @package App.Modules.ModuleTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ModuleTemplate\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'ModuleTemplate')->first();

        if(!$module)
        {
            $idModule = \DB::table('module')->insertGetId(
                array (
                    'nameModule' => 'ModuleTemplate',
                    'labelModule' => 'Шаблоны модулей',
                    'status' => 1,
                )
            );

            $idAdminSection = \DB::table('adminSection')->insertGetId(
                array (
                    'idModule' => $idModule,
                    'labelSection' => 'Шаблоны модулей',
                    'bundle' => 'MANEGER',
                    'iconSmall' => 'app/Modules/ModuleTemplate/Admin/images/icon_small.png',
                    'iconBig' => 'app/Modules/ModuleTemplate/Admin/images/icon_big.png',
                    'menuLeft' => 0,
                    'pathToCss' => 'app/Modules/ModuleTemplate/Admin/css/main.css',
                    'pathToJs' => 'app/Modules/ModuleTemplate/Admin/js/index.js',
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
