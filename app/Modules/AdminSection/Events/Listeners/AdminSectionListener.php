<?php
/**
 * Модуль Разделы административной системы.
 * Этот модуль содержит все классы для работы с разделами административной системы.
 * @package App.Modules.AdminSection
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\AdminSection\Events\Listeners;

use App\Modules\AdminSection\Models\AdminSectionEloquent as AdminSection;

/**
 * Класс обработчик событий для модели разделов административной системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AdminSectionListener
{
	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\AdminSection\Models\AdminSectionEloquent $AdminSection Модель для таблицы разделов административной системы.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleting(AdminSection $AdminSection)
	{
	$AdminSection->UserRoleAdminSection()->delete();
	return true;
	}
}