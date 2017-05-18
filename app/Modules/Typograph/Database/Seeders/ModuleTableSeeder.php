<?php
/**
 * Модуль Типографи.
 * Этот модуль содержит все классы для работы с типографом.
 * @package App.Modules.Typograph
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Typograph\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'Typograph')->first();

        if(!$module)
        {
            \DB::table('module')->insert(array (
                    0 =>
                        array (
                            'nameModule' => 'Typograph',
                            'labelModule' => 'Типограф',
                            'status' => 1,
                        )
                )
            );
        }
    }
}
