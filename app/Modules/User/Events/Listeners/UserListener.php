<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\User\Events\Listeners;

use App\Modules\User\Models\UserEloquent as User;
use Image;

/**
 * Класс обработчик событий для модели пользователей.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserListener
{
	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\User\Models\UserEloquent $User Модель для таблицы пользователей.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleting(User $User)
	{
	    if($User->idImageSmall) Image::destroy($User->idImageSmall["idImage"]);
        if($User->idImageMiddle) Image::destroy($User->idImageMiddle["idImage"]);

	$User->UserGroupOfUser()->delete();
	return true;
	}
}