<?php
/**
 * Модуль Виджеты.
 * Этот модуль содержит все классы для работы с виджетами.
 * @package App.Modules.Widget
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Widget\Events\Listeners;

use App\Modules\Widget\Models\WidgetEloquent as Widget;

/**
 * Класс обработчик событий для модели виджета.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class WidgetListener
{
	/**
	 * Обработчик события при добавлении записи.
	 * @param \App\Modules\Widget\Models\WidgetEloquent $Widget Модель для таблицы виджетов.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function creating(Widget $Widget)
	{
	$result = $Widget->newQuery()
	->where("idModule", $Widget->idModule)
	->where("actionWidget", $Widget->actionWidget)
	->first();

		if($result)
		{
		$Widget->addError('validate', 'Вы не можете добавить такой виджет, т.к. он уже есть в базе данных!', 'actionWidget');
		return false;
		}

	return true;
	}


	/**
	 * Обработчик события при обновлении записи.
	 * @param \App\Modules\Widget\Models\WidgetEloquent $Widget Модель для таблицы виджетов.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function updating(Widget $Widget)
	{
	$result = $Widget->newQuery()
	->where("idWidget", "!=", $Widget->idWidget)
	->where("idModule", $Widget->idModule)
	->where("actionWidget", $Widget->actionWidget)
	->first();

		if($result)
		{
		$Widget->addError('validate', 'Вы не можете добавить такой виджет, т.к. он уже есть в базе данных!', 'actionWidget');
		return false;
		}

	return true;
	}
}