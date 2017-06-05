<?php
/**
 * Модуль Компонента.
 * Этот модуль содержит все классы для работы с компонентами системы.
 * @package App.Modules.Component
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Component\Events\Listeners;

use App\Modules\Component\Models\ComponentEloquent as Component;

/**
 * Класс обработчик событий для модели компонента.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ComponentListener
{
	/**
	 * Обработчик события при добавлении записи.
	 * @param \App\Modules\Component\Models\ComponentEloquent $Component Модель для таблицы компонента.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function creating(Component $Component)
	{
	$result = $Component->newQuery()
	->where("idModule", $Component->idModule)
	->where("controller", $Component->controller)
	->where("nameComponent", $Component->nameComponent)
	->first();

		if($result)
		{
        $Component->addError('validate', 'Вы не можете добавить такой компонент, т.к. он уже есть в базе данных!', 'nameComponent');
		return false;
		}

	return true;
	}


	/**
	 * Обработчик события при обновлении записи.
	 * @param \App\Modules\Component\Models\ComponentEloquent $Component Модель для таблицы компонента.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function updating(Component $Component)
	{
	$result = $Component->newQuery()
	->where("idComponent", "!=", $Component->idComponent)
    ->where("idModule", $Component->idModule)
    ->where("controller", $Component->controller)
    ->where("nameComponent", $Component->nameComponent)
	->first();

		if($result)
		{
        $Component->addError('validate', 'Вы не можете добавить такой компонент, т.к. он уже есть в базе данных!', 'nameComponent');
		return false;
		}

	return true;
	}
}