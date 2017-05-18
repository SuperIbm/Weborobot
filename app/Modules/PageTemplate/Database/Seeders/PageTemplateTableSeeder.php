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
 * Класс для запуска установки главного шаблона.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageTemplateTableSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
        \DB::table('PageTemplate')->delete();

        \DB::table('PageTemplate')->insert(array (
            0 =>
                array (
                    'idPageTemplate' => 1,
                    'labelTemplate' => 'Главный',
                    'nameTemplate' => 'general',
                    'countBlocks' => 1,
                    'idImage' => NULL,
                    'status' => 1,
                ),
        ));
    }
}
