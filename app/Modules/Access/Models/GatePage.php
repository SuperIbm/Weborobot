<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 * @package App.Modules.Access
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Access\Models;

use App\Modules\Page\Repositories\Page;
use App\Modules\Page\Models\PageEloquent as PageModel;
use App\Modules\User\Repositories\User as UserRepository;

/**
 * Класс для определения доступа к страницам сайта.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GatePage
{
/**
 * Репозитарий для работы со страницами.
 * @var \App\Modules\Page\Repositories\Page
 * @version 1.0
 * @since 1.0
 */
protected $_Page;

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
	 * @param \App\Modules\Page\Repositories\Page $Page Репозитарий для работы со страницами.
	 * @version 1.0
	 * @since 1.0
	 */
	public function __construct(UserRepository $User, Page $Page)
	{
	$this->_User = $User;
	$this->_Page = $Page;
	}

	/**
	 * Получение репозитария для работы со страницами.
	 * @return \App\Modules\Page\Repositories\Page Репозитарий для работы по страницами.
	 * @version 1.0
	 * @since 1.0
	 */
	public function getPage()
	{
	return $this->_Page;
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
	 * @param int|array $page Id или массив данных страницы.
	 * @return bool Вернет true, если есть доступ.
	 * @version 1.0
	 * @since 1.0
	 */
	public function check($user, $page)
	{
	$gates = $this->getUser()->gates($user["idUser"]);

		if(is_array($page)) $page = $this->getPage()->get($page["idPage"], null, true);
		else if($page instanceof PageModel) $page = $this->getPage()->get($page->idPage, null, true);
		else if(is_string($page)) $page = $this->getPage()->getByDirname($page, null, true);
		else if(is_numeric($page)) $page = $this->getPage()->get($page, null, true);

		if(isset($page) && count($gates["pages"]) && $page["modeAccess"] == "Ограниченный")
		{
			for($i = 0; $i < count($gates["pages"]); $i++)
			{
				if($gates["pages"][$i]["idPage"] == $page["idPage"]) return true;
			}

		return false;
		}

	return true;
	}
}