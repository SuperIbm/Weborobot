<?php
/**
 * Модуль Логирование.
 * Этот модуль содержит все классы для работы с логированием.
 * @package App.Modules.Log
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Log\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки начальными данными.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogDatabaseSeeder extends Seeder
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

        $this->call(\App\Modules\Log\Database\Seeders\ModuleTableSeeder::class);
    }
}
