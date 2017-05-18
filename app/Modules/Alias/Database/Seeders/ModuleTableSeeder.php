<?php
/**
 * Модуль Псевдонимы.
 * Этот модуль содержит все классы для работы с псевдонимами.
 * @package App.Modules.Alias
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Alias\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'Alias')->first();
    
        if(!$module)
        {
            $idModule = \DB::table('module')->insertGetId
            (
                array (
                    'nameModule' => 'Alias',
                    'labelModule' => 'Псевдонимы',
                    'status' => 1,
                )
            );

            $idAdminSection = \DB::table('adminSection')->insertGetId
            (
                array (
                    'idModule' => $idModule,
                    'labelSection' => 'Псевдонимы',
                    'bundle' => 'MANEGER',
                    'iconSmall' => 'engine/app/Modules/Alias/Admin/images/icon_small.png',
                    'iconBig' => 'engine/app/Modules/Alias/Admin/images/icon_big.png',
                    'menuLeft' => 0,
                    'pathToCss' => 'engine/app/Modules/Alias/Admin/css/main.css',
                    'pathToJs' => 'engine/app/Modules/Alias/Admin/js/index.js',
                    'weight' => 7,
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
