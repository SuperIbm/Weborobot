<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\User\Events\Listeners;

use App\Modules\User\Models\UserGroupEloquent as UserGroup;
use Image;

/**
 * Класс обработчик событий для модели групп пользователей.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserGroupListener
{
	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\User\Models\UserGroupEloquent $UserGroup Модель для таблицы групп пользователей.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleting(UserGroup $UserGroup)
	{
	$UserGroup->UserGroupOfUser()->delete();
	$UserGroup->UserGroupPage()->delete();
	$UserGroup->UserGroupRole()->delete();
	}
}