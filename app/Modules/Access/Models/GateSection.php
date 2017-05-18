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

/**
 * Класс для определения доступа к разделам административной системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateSection
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
	 * @param string $section Название секции админстративной системы.
	 * @param string $type Тип доступа: isRead, isCreate, isUpdate, isDestroy.
	 * @return bool Вернет true, если есть доступ.
	 * @version 1.0
	 * @since 1.0
	 */
	public function check($user, $section, $type)
	{
	$gates = $this->getUser()->gates($user["idUser"]);

		if(isset($gates["sections"][$section][$type]) && $gates["sections"][$section][$type] == true) return true;

	return false;
	}
}