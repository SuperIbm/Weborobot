<?php
/**
 * Модуль Компонента страницы.
 * Этот модуль содержит все классы для работы с компонентами страницы.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponent\Events\Listeners;

use App\Modules\PageComponent\Models\PageComponentEloquent;

/**
 * Класс обработчик событий для модели компонента на странице.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageComponentListener
{
	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\PageComponent\Models\PageComponentEloquent $PageComponent Модель для таблицы компонентов страницы.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleting(PageComponentEloquent $PageComponent)
	{
	$PageComponent->PageComponentSetting()->delete();
	}
}