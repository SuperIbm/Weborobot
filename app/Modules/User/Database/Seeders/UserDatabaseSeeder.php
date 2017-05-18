<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки начальными данными.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserDatabaseSeeder extends Seeder
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

        $this->call(\App\Modules\User\Database\Seeders\ModuleTableSeeder::class);
        $this->call(\App\Modules\User\Database\Seeders\UserGroupOfUserTableSeeder::class);
        $this->call(\App\Modules\User\Database\Seeders\UserGroupRoleTableSeeder::class);
        $this->call(\App\Modules\User\Database\Seeders\UserGroupTableSeeder::class);
        $this->call(\App\Modules\User\Database\Seeders\UserRoleTableSeeder::class);
        $this->call(\App\Modules\User\Database\Seeders\UserTableSeeder::class);
    }
}
