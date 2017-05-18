<?php
/**
 * Модуль Настройки компонента страницы.
 * Этот модуль содержит все классы для работы настройками компонента на странице.
 * @package App.Modules.PageComponentSetting
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponentSetting\Database\Seeders;

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
    $module = \DB::table('module')->where('nameModule', 'PageComponentSetting')->first();

        if(!$module)
        {
            \DB::table('module')->insert(array (
                    0 =>
                        array (
                            'nameModule' => 'PageComponentSetting',
                            'labelModule' => 'Настройки компонентов страницы',
                            'status' => 1,
                        ),
                )
            );
        }
    }
}
