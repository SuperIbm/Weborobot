<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки страниц.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageTableSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
        \DB::table('Page')->delete();

        \DB::table('Page')->insert(array (
            0 =>
                array (
                    'idPage' => 1,
                    'idPageTemplate' => 1,
                    'idPageReferen' => 0,
                    'namePage' => 'Главная',
                    'nameLink' => NULL,
                    'description' => NULL,
                    'keywords' => NULL,
                    'title' => NULL,
                    'html' => NULL,
                    'weight' => 0,
                    'showInMenu' => 1,
                    'modeAccess' => 'FREE',
                    'redirect' => NULL,
                    'dateEdit' => '1980-01-01 00:00:00',
                    'status' => 1,
                ),
        ));
    }
}
