<?php
/**
 * Модуль Файловая система.
 * Этот модуль содержит все классы для работы с файловой системой.
 * @package App.Modules.Filesystem
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Filesystem\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки начальными данными.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FilesystemDatabaseSeeder extends Seeder
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

        $this->call(\App\Modules\Filesystem\Database\Seeders\ModuleTableSeeder::class);
    }
}
