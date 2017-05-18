<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 */
namespace App\Modules\Page\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад класса страниц.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Page extends Facade
{
	/**
	 * Получить зарегистрированное имя компонента.
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
	return 'page';
	}
}
?>