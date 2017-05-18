<?php
/**
 * Модуль Поддержки.
 * Этот модуль содержит все классы для работы поддержкой в административной системе.
 * @package App.Modules.Support
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Support\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Класс для запуска установки данных администратора для поддержки.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SupportTableSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
        \DB::table('Support')->delete();

        \DB::table('Support')->insert(array (
            0 =>
                array (
                    'idSupport' => 1,
                    'email' => 'myadmin@mail.ru',
                    'fio' => 'Администратор',
                ),
        ));
    }
}
