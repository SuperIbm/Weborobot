<?php
/**
 * Модуль Captcha .
 * Этот модуль содержит все классы для работы с Captcha.
 * @package App.Modules.Captcha
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Captcha\Models;

use Illuminate\Support\Manager;


/**
 * Класс системы генерирования каптчи.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CaptchaManager extends Manager
{
	/**
	 * @see \Illuminate\Support\Manager::getDefaultDriver
	 */
	public function getDefaultDriver()
	{
	return $this->app['config']['captcha.driver'];
	}
}
?>