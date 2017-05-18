<?php
/**
 * Модуль Шаблоны модуля.
 * Этот модуль содержит все классы для работы с шаблонами модулей системы.
 * @package App.Modules.ModuleTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ModuleTemplate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки начальными данными.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleTemplateDatabaseSeeder extends Seeder
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

        $this->call(\App\Modules\ModuleTemplate\Database\Seeders\ModuleTableSeeder::class);
    }
}
