<?php
/**
 * Модуль Инфоблоков.
 * Этот модуль содержит все классы для работы с инфоблоками.
 * @package App.Modules.Infoblock
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Infoblock\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'Infoblock')->first();

        if(!$module)
        {
            $idModule = \DB::table('module')->insertGetId(
                array (
                    'nameModule' => 'Infoblock',
                    'labelModule' => 'Инфоблоки',
                    'status' => 1,
                )
            );

            \DB::table('component')->insert(array (
                    0 =>
                        array (
                            'idModule' => $idModule,
                            'controller' => 'InfoblockController',
                            'nameComponent' => 'get',
                            'labelComponent' => 'Установить',
                            'pathToCss' => NULL,
                            'pathToJs' => 'app/Modules/Infoblock/Admin/js/component/get/js/index.js',
                            'status' => 1
                        )
                )
            );

            \DB::table('ModuleTemplate')->insert(array (
                    0 =>
                        array (
                            'idModule' => $idModule,
                            'labelTemplate' => 'Установить',
                            'htmlTpl' =>
'{if $INFOBLOCK}
    {$INFOBLOCK.html}
{/if}',
                            'status' => 1,
                        )
                )
            );

            $idAdminSection = \DB::table('adminSection')->insertGetId(
                array (
                    'idModule' => $idModule,
                    'labelSection' => 'Инфоблоки',
                    'bundle' => 'CONTENT',
                    'iconSmall' => 'app/Modules/Infoblock/Admin/images/icon_small.png',
                    'iconBig' => 'app/Modules/Infoblock/Admin/images/icon_big.png',
                    'menuLeft' => 1,
                    'pathToCss' => 'app/Modules/Infoblock/Admin/css/main.css',
                    'pathToJs' => 'app/Modules/Infoblock/Admin/js/index.js',
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
