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

/**
 * Класс наполнения начальными данными ролей по умолчанию.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserRoleTableSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
        \DB::table('UserRole')->delete();

        \DB::table('UserRole')->insert(array (
            0 =>
                array (
                    'idUserRole' => 1,
                    'nameRole' => 'Администрирование',
                    'status' => 1,
                ),
            1 =>
                array (
                    'idUserRole' => 2,
                    'nameRole' => 'Редактирование',
                    'status' => 1,
                ),
        ));
    }
}
