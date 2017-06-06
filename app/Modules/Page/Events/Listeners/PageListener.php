<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Page\Events\Listeners;

use App\Modules\Page\Models\PageEloquent as Page;

/**
 * Класс обработчик событий для модели страниц.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageListener
{
	/**
	 * Обработчик события при добавлении записи.
	 * @param \App\Modules\Page\Models\PageEloquent $Page Модель для таблицы страниц сайта.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function creating(Page $Page)
	{
	$result = $Page->newQuery()
	->where("nameLink", $Page->nameLink)
	->where("idPageReferen", $Page->idPageReferen)
	->first();

		if($result)
		{
		$Page->addError('validate', 'Вы не можете добавить такую страницу, т.к. она уже есть в базе данных!', 'nameLink');
		return false;
		}

	return true;
	}


	/**
	 * Обработчик события при обновлении записи.
	 * @param \App\Modules\Page\Models\PageEloquent $Page Модель для таблицы страниц сайта.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function updating(Page $Page)
	{
	$result = $Page->newQuery()
	->where("idPage", "!=", $Page->idPage)
	->where("nameLink", $Page->nameLink)
	->where("idPageReferen", $Page->idPageReferen)
	->first();

		if($result)
		{
		$Page->addError('validate', 'Вы не можете добавить такую страницу, т.к. она уже есть в базе данных!', 'nameLink');
		return false;
		}

	return true;
	}


	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\Page\Models\PageEloquent $Page Модель для таблицы страниц сайта.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleting(Page $Page)
	{
	$Page->UserGroupPage()->delete();
	$Page->UserRolePage()->delete();
    return true;
	}
}