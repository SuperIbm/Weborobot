<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 * @package App.Modules.Access
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Access\Events\Listeners;

use Log;
use Session;

/**
 * Класс обработчик событий при удачном выходе пользователя.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogSuccessfulLogout
{
	/**
	 * Обработчик события.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function handle()
	{
    Session::forget('user');

		Log::info("Выход пользователя",
			[
			"module" => "Auth",
            "type" => "authorization"
			]
		);
	}
}