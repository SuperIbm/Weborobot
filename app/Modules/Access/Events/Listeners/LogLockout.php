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
 * Класс обработчик событий при блокировки пользователя.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogLockout
{
	/**
	 * Обработчик события.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function handle($Attempting)
	{
	$Attempting->credentials["type"] = "auth";
	Log::info("Блокировка пользователя ".$Attempting->credentials["login"], $Attempting->credentials);
	}
}