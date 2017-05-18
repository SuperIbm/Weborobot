<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад класса статистики сайта.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Seo extends Facade
{
	/**
	 * Получить зарегистрированное имя компонента.
	 * @return string
	 * @version 1.0
	 * @since 1.0
	 */
	protected static function getFacadeAccessor()
	{
	return 'seo';
	}
}
?>