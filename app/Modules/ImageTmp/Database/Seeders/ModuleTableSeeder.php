<?php
/**
 * Модуль Временных изображений.
 * Этот модуль содержит все классы для работы с временными изображениями.
 * @package App.Modules.ImageTmp
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ImageTmp\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'ImageTmp')->first();

        if(!$module)
        {
            \DB::table('module')->insert(array (
                    0 =>
                        array (
                            'nameModule' => 'ImageTmp',
                            'labelModule' => 'Временные изображения',
                            'status' => 1,
                        )
                )
            );
        }


    }
}
