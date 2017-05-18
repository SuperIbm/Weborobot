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

/**
 * Класс обработчик событий при попытки аунтификации.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogAuthenticationAttempt
{
	/**
	 * Обработчик события.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function handle($Attempting)
	{
		Log::info("Попытка аунтификации пользователя ".$Attempting->credentials["login"],
			[
			"login" => $Attempting->credentials["login"],
			"module" => "Auth",
            "type" => "authorization"
			]
		);
	}
}