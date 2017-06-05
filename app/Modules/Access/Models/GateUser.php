<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 * @package App.Modules.Access
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Access\Models;

use App\Modules\User\Repositories\User as UserRepository;
use Session;

/**
 * Класс для определения доступа к страницам сайта через проверку является ли этот пользователь "Пользователи".
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateUser
{
/**
 * Репозитарий пользователей.
 * @var \App\Modules\User\Repositories\User
 * @version 1.0
 * @since 1.0
 */
private $_User;

	/**
	 * Конструктор.
	 * @param \App\Modules\User\Repositories\User $User Репозитарий пользователя.
	 * @version 1.0
	 * @since 1.0
	 */
	public function __construct(UserRepository $User)
	{
	$this->_User = $User;
	}

	/**
	 * Получение репозитария для работы с пользователями.
	 * @return \App\Modules\User\Repositories\User Репозитарий для работы с пользователями.
	 * @version 1.0
	 * @since 1.0
	 */
	public function getUser()
	{
	return $this->_User;
	}

	/**
	 * Метод для определения доступа.
	 * @param array $user Данные пользователя.
	 * @param bool $status Если указать true, то значит нужно проверить истенность, что это "Пользователи", если false, то значит ложность.
	 * @return bool Вернет true, если есть доступ.
	 * @version 1.0
	 * @since 1.0
	 */
	public function check($user, $status = true)
	{
	$gates = $this->getUser()->gates($user["idUser"]);

        if((count($gates["groups"]) && $status == true) || (count($gates["groups"]) == 0 && $status == false)) return true;
		else return false;
	}
}