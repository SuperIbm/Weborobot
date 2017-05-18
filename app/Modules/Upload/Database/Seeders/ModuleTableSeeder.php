<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'Upload')->first();

        if(!$module)
        {
            $idModule = \DB::table('module')->insertGetId(
                array (
                    'nameModule' => 'Upload',
                    'labelModule' => 'Обновления',
                    'status' => 1,
                )
            );

            \DB::table('widget')->insert(array (
                    0 =>
                        array (
                            'idModule' => $idModule,
                            'actionWidget' => 'upload',
                            'labelWidget' => 'Обновления',
                            'icon' => 'app/Modules/Upload/Admin/images/icon_small.png',
                            'pathToCss' => NULL,
                            'pathToJs' => 'app/Modules/Upload/Admin/js/widget/upload/js/index.js',
                            'def' => 1,
                            'status' => 1,
                        )
                )
            );

            $idAdminSection = \DB::table('adminSection')->insertGetId(
                array (
                    'idModule' => $idModule,
                    'labelSection' => 'Обновления',
                    'bundle' => 'SYSTEM',
                    'iconSmall' => 'app/Modules/Upload/Admin/images/icon_small.png',
                    'iconBig' => 'app/Modules/Upload/Admin/images/icon_big.png',
                    'menuLeft' => 0,
                    'pathToCss' => 'app/Modules/Upload/Admin/css/main.css',
                    'pathToJs' => 'app/Modules/Upload/Admin/js/index.js',
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
