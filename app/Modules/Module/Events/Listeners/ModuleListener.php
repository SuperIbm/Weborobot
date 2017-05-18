<?php
/**
 * Модуль "Модулей".
 * Этот модуль содержит все классы для работы с модулями.
 * @package App.Modules.Module
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Module\Events\Listeners;

use App\Modules\Module\Models\ModuleEloquent;

/**
 * Класс обработчик событий для модели модулей.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleListener
{
	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\Module\Models\ModuleEloquent $Module Модель для таблицы модулей.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleting(ModuleEloquent $Module)
	{
	$Module->ModuleTemplate()->delete();
	$Module->Component()->delete();
    $Module->AdminSection()->delete();
    $Module->Upload()->delete();

    return true;
	}
}