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
 * Класс обработчик событий при регистрации пользователя.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogRegisteredUser
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
	Log::info("Регистрация пользователя ".$Attempting->credentials["login"], $Attempting->credentials);
	}
}