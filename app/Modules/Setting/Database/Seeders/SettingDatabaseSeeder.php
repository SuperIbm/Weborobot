<?php
/**
 * Модуль Настройки сайта.
 * Этот модуль содержит все классы для работы с настройками сайта.
 * @package App.Modules.Setting
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки начальными данными.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SettingDatabaseSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
        Model::unguard();

        $this->call(\App\Modules\Setting\Database\Seeders\ModuleTableSeeder::class);
    }
}