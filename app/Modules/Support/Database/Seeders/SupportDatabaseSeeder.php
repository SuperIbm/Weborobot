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
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки начальными данными.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SupportDatabaseSeeder extends Seeder
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

        $this->call(\App\Modules\Support\Database\Seeders\SupportTableSeeder::class);
        $this->call(\App\Modules\Support\Database\Seeders\ModuleTableSeeder::class);
    }
}
