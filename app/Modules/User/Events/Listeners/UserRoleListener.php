<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\User\Events\Listeners;

use App\Modules\User\Models\UserRoleEloquent as UserRole;

/**
 * Класс обработчик событий для модели ролей пользователей.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserRoleListener
{
	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\User\Models\UserRoleEloquent $UserRole Модель для таблицы ролей пользователей.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleting(UserRole $UserRole)
	{
	$UserRole->UserGroupRole()->delete();
	$UserRole->UserRoleAdminSection()->delete();
	$UserRole->UserRolePage()->delete();
    return true;
	}
}