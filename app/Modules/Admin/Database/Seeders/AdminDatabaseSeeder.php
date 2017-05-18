<?php
/**
 * Модуль Ядро административной системы.
 * Этот модуль содержит все классы для работы с ядром административной системы.
 * @package App.Modules.AdminSection
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки начальными данными.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AdminDatabaseSeeder extends Seeder
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

        $this->call(\App\Modules\Admin\Database\Seeders\ModuleTableSeeder::class);
    }
}
