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
 * Класс наполнения начальными данными групп по умолчанию.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserGroupTableSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
        \DB::table('UserGroup')->delete();

        \DB::table('UserGroup')->insert(array (
            0 =>
                array (
                    'idUserGroup' => 1,
                    'nameGroup' => 'Администраторы',
                    'status' => 1,
                ),
            1 =>
                array (
                    'idUserGroup' => 3,
                    'nameGroup' => 'Пользователи',
                    'status' => 1,
                ),
            2 =>
                array (
                    'idUserGroup' => 2,
                    'nameGroup' => 'Редакторы',
                    'status' => 1,
                ),
        ));
    }
}
