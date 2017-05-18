<?php
/**
 * Модуль Кеширования.
 * Этот модуль содержит все классы для работы с кешированием.
 * @package App.Modules.Cache
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Cache\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'Cache')->first();
    
        if(!$module)
        {
            \DB::table('module')->insert(array (
                    0 =>
                        array (
                            'nameModule' => 'Cache',
                            'labelModule' => 'Кеширование',
                            'status' => 1,
                        )
                )
            );
        }
    }
}
