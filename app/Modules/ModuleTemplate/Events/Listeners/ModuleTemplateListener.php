<?php
/**
 * Модуль Шаблоны модуля.
 * Этот модуль содержит все классы для работы с шаблонами модулей системы.
 * @package App.Modules.ModuleTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ModuleTemplate\Events\Listeners;

use App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent as ModuleTemplate;

/**
 * Класс обработчик событий для модели шаблонов модулей.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleTemplateListener
{
	/**
	 * Обработчик события при добавлении записи.
	 * @param \App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent $ModuleTemplate Модель для таблицы шаблонов модулей.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function creating(ModuleTemplate $ModuleTemplate)
	{
		$result = $ModuleTemplate->newQuery()
		->where("labelTemplate", $ModuleTemplate->labelTemplate)
		->where("idModule", $ModuleTemplate->idModule)
		->first();

		if($result)
		{
		$ModuleTemplate->addError('validate', 'Вы не можете добавить такой шаблон, т.к. он уже есть в базе данных!', 'labelTemplate');
		return false;
		}

	return true;
	}


	/**
	 * Обработчик события при обновлении записи.
	 * @param \App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent $ModuleTemplate Модель для таблицы шаблонов модулей.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function updating(ModuleTemplate $ModuleTemplate)
	{
		$result = $ModuleTemplate->newQuery()
		->where("idModuleTemplate", "!=", $ModuleTemplate->idModuleTemplate)
		->where("labelTemplate", $ModuleTemplate->labelTemplate)
		->where("idModule", $ModuleTemplate->idModule)
		->first();

		if($result)
		{
        $ModuleTemplate->addError('validate', 'Вы не можете добавить такой шаблон, т.к. он уже есть в базе данных!', 'labelTemplate');
		return false;
		}

	return true;
	}
}