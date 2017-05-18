<?php
/**
 * Модуль Captcha .
 * Этот модуль содержит все классы для работы с Captcha.
 * @package App.Modules.Captcha
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Captcha\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад класса для работы с каптчей.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Captcha extends Facade
{
	/**
	 * Получить зарегистрированное имя компонента.
	 * @return string
	 * @version 1.0
	 * @since 1.0
	 */
	protected static function getFacadeAccessor()
	{
	return 'captcha';
	}
}
?>