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
 * Класс наполнения начальными данными: главный администратор по умолчанию.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
        \DB::table('User')->delete();

        \DB::table('User')->insert(array (
            0 =>
                array (
                    'idUser' => 1,
                    'idImageSmall' => NULL,
                    'idImageMiddle' => NULL,
                    'login' => 'admin',
                    'password' => 'eyJpdiI6IksxdGNcL3h0eWh4dDFVZHROTUNSNTNRPT0iLCJ2YWx1ZSI6IlkzNG5tN3dcL0RmUkJPMGpFckwzYWlRPT0iLCJtYWMiOiJkNjJjY2Q4ZTk3NjczMzczYzQ1NGRiNGUwY2ZkZjYyNzg5NzVjYWY0MDZjNjE2M2MzY2UxMmVjMGYwNWZmOTA3In0=',
                    'remember_token' => NULL,
                    'firstname' => NULL,
                    'secondname' => NULL,
                    'lastname' => NULL,
                    'email' => NULL,
                    'telephone' => NULL,
                    'sex' => NULL,
                    'birthday' => NULL,
                    'icq' => NULL,
                    'skype' => NULL,
                    'zip' => NULL,
                    'country' => NULL,
                    'city' => NULL,
                    'street' => NULL,
                    'passportSeriaAndNumber' => NULL,
                    'passportWhoMade' => NULL,
                    'passportWhenMade' => NULL,
                    'passportCodeSection' => NULL,
                    'passportAdress' => NULL,
                    'organForma' => NULL,
                    'organName' => NULL,
                    'organAbout' => NULL,
                    'site' => NULL,
                    'dateAdd' => '1980-01-01 00:00:00',
                    'dateLastEnter' => '1980-01-01 00:00:00',
                    'ip' => '127.0.0.1',
                    'status' => 1,
                ),
        ));
    }
}
