<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Page\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад класса текущей страницы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageCurrent extends Facade
{
	/**
	 * Получить зарегистрированное имя компонента.
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
	return 'pageCurrent';
	}
}
?>