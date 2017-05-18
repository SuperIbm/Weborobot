<?php
/**
 * Модуль Captcha .
 * Этот модуль содержит все классы для работы с Captcha.
 * @package App.Modules.Captcha
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Captcha\Contracts;

use Session;

/**
 * Абстрактный класс для проектирования собственной системы проектирования каптчи.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Captcha
{
	/**
	 * Получение байт кода картинки каптчи.
	 * @param array $params Параметры для проектирования каптчи.
	 * @return string Вернет байт код изображения.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function get($params = null);


	/**
	 * Генерация текста для каптчи.
	 * @return string Текст для каптчи.
	 * @since 1.0
	 * @version 1.0
	 */
	public function text()
	{
	return "".rand(1000, 9999);
	}


	/**
	 * Получение сгенерированного текста.
	 * @return string Вернет сгенерированный текст.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getText()
	{
	$text = $this->text();
	Session::put("captcha", $text);
	return $text;
	}


	/**
	 * Проверка на соответствие.
	 * Позволяет проверить соответствует ли выведенная надпись на каптчи той, что была введена пользователем.
	 * @param string $text Строка каптчи которую ввел пользователь.
	 * @return bool Если вернет true, то пользователь ввел верную строку каптчи.
	 * @since 1.0
	 * @version 1.0
	 */
	public function is($text)
	{
		if(Session::get("captcha") == $text) return true;

	return false;
	}
}