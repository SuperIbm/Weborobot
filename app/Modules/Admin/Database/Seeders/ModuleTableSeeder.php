<?php
/**
 * Модуль Ядро административной системы.
 * Этот модуль содержит все классы для работы с ядром административной системы.
 * @package App.Modules.AdminSection
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Admin\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'Admin')->first();
        
        if(!$module)
        {
            \DB::table('module')->insert(array (
                    0 =>
                        array (
                            'nameModule' => 'Admin',
                            'labelModule' => 'Ядро административной системы',
                            'status' => 1,
                        )
                )
            );
        }
    }
}
