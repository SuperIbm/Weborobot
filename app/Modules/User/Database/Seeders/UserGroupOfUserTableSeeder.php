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
 * Класс наполнения начальными данными выбранные группы пользователя.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserGroupOfUserTableSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
    \DB::table('UserGroupOfUser')->delete();

        \DB::table('UserGroupOfUser')->insert(array (
            0 =>
                array (
                    'idUserGroupOfUser' => 1,
                    'idUserGroup' => 1,
                    'idUser' => 1,
                ),
        ));
    }
}
