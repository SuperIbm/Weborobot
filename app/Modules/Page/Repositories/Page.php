<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Page\Repositories;

use App\Models\Repositary;

/**
 * Абстрактный класс построения репозитария.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Page extends Repositary
{
/**
 * Полученные раннее страницы.
 * Будем хранить данные полученных ранее страниц, чтобы снизить нагрузку на систему, которая вынуждена формировать сложные запросы для получения страницы.
 * Т.к. формирования URL страницы невозможно получить одним запросом.
 * @var array
 * @version 1.0
 * @since 1.0
 */
private static $_pages = Array();

	/**
	 * Получение страницы по ее пути.
	 * @param string $dirname Путь к странице.
	 * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
	 * @param bool $inherit Требуется ли взять зависмости у вышестоящих страниц.
	 * @return array|bool Массив данных.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getByDirname($dirname, $active = null, $inherit = false)
	{
	$page = self::_getByPath($dirname, $active, $inherit);

		if($page) return $page;
		else
		{
		$dirname = explode("/", "/".$dirname);
		unset($dirname[count($dirname) - 1]);

		$id = 0;
		$page = Array();

			for($i = 0; $i < count($dirname); $i++)
			{
			$nameLink = addslashes($dirname[$i]) == "" ? null : addslashes($dirname[$i]);

				$pages = $this->read
				(
					[
						[
						'property' => "nameLink",
						'value' => $nameLink
						],
						[
						'property' => "idPageReferen",
						'value' => $id
						]
					],
					$active
				);

				if(!$pages) return false;
				else
				{
				$page = $pages[0];
				$id = $page["idPage"];
				$this->_setById($id, $page, false);
				}
			}

			if($inherit == true)
			{
			$page = $this->_getInherit($page);
			$this->_setById($page["idPage"], $page, true);
			}

		return $page;
		}
	}

	/**
	 * Получить унаследованные параметры.
	 * @param array $page Данные страницы.
	 * @return array Данные страницы с унаследованными значениями.
	 * @since 1.0
	 * @version 1.0
	 */
	protected function _getInherit($page)
	{
		if(!isset($page["path"])) $page["path"] = "";

		if($page["idPageReferen"] != 0 &&
			(
				$page["idPageTemplate"] == "" ||
				$page["modeAccess"] == "" ||
				$page["modeAccess"] == "Наследовать" ||
				$page["description"] == "" ||
				$page["keywords"] == "" ||
				$page["title"] == "" ||
                $page["path"] == ""
			)
		)
		{
		$pageParent = $this->get($page["idPageReferen"], null, true);

			if($pageParent)
			{
				if(isset($pageParent["path"])) $page["path"] = $pageParent["path"].$page["nameLink"]."/";
				if(!$page["idPageTemplate"]) $page["idPageTemplate"] = $pageParent["idPageTemplate"];
				if(!$page["modeAccess"] || $page["modeAccess"] == "Наследовать") $page["modeAccess"] = $pageParent["modeAccess"];
				if(!$page["description"]) $page["description"] = $pageParent["description"];
				if(!$page["keywords"]) $page["keywords"] = $pageParent["keywords"];
				if(!$page["title"]) $page["title"] = $pageParent["title"];
			}
		}

	return $page;
	}

	/**
	 * Получение страницы по ее ID из базы ранее полученных страниц.
	 * @param int $id ID страницы.
	 * @param bool $active Если установить true, то взять только активную страницу.
	 * @param bool $inherit Если установить true, то взять данные которые были унаследованы у других страниц.
	 * @return array|bool Массив данных страницы.
	 * @since 1.0
	 * @version 1.0
	 */
    protected static function _getById($id, $active = false, $inherit = false)
	{
		if(isset(self::$_pages[$id]))
		{
			if($inherit && isset(self::$_pages[$id]["inherit"])) $page = self::$_pages[$id]["inherit"];
			else if($inherit == false && isset(self::$_pages[$id]["noInherit"])) $page = self::$_pages[$id]["noInherit"];
			else return false;

			if($active == true)
			{
				if($page["status"] == "Активен") return $page;
				else return false;
			}
			else return $page;
		}
		else return false;
	}

	/**
	 * Установка данных страницы по ее ID в базу ранее полученных страниц.
	 * @param int $id ID страницы.
	 * @param array $page Данные страницы.
	 * @param bool $inherit Если установить true, то это определяет что данные этой страницы полученны методом унаследования.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
    protected static function _setById($id, $page, $inherit = false)
	{
		if(!isset(self::$_pages[$id])) self::$_pages[$id] = Array();

		if($inherit) self::$_pages[$id]["inherit"] = $page;
		else self::$_pages[$id]["noInherit"] = $page;
	}

	/**
	 * Получение страницы по ее пути из базы ранее полученных страниц.
	 * @param string $dirname Путь к странице.
	 * @param bool $active Если установить true, то взять только активную страницу.
	 * @param bool $inherit Если установить true, то взять данные которые были унаследованы у других страниц.
	 * @return array|bool Массив данных страницы.
	 * @since 1.0
	 */
    protected static function _getByPath($dirname, $active = false, $inherit = false)
	{
		if(count(self::$_pages))
		{
			foreach(self::$_pages as $k => $v)
			{
			$data = null;

				if($inherit == true && isset(self::$_pages[$k]["inherit"])) $data = self::$_pages[$k]["inherit"];
				else if($inherit == false && isset(self::$_pages[$k]["noInherit"])) $data = self::$_pages[$k]["noInherit"];

				if($data)
				{
					if($data["path"] == $dirname)
					{
						if($active == true && $data["status"] == "Активен") return $data;
						else if($active == false) return $data;
						else return false;
					}
				}
			}

		return false;
		}
		else return false;
	}

    /**
     * Получить по первичному ключу.
     * @param int $id Первичный ключ.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param bool $inherit Требуется ли взять зависмости у вышестоящих страниц.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract public function get($id, $active = null, $inherit = false);

	/**
	 * Чтение данных.
	 * @param array $filters Фильтрация данных.
	 * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
	 * @param bool $inherit Требуется ли взять зависмости у вышестоящих страниц.
	 * @return array Массив данных.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function read($filters = null, $active = null, $sorts = null, $offset = null, $limit = null, $inherit = false);

	/**
	 * Создание.
	 * @param array $data Данные для добавления.
	 * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function create(array $data);

	/**
	 * Обновление.
	 * @param int $id Id записи для обновления.
	 * @param array $data Данные для обновления.
	 * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function update($id, array $data);

	/**
	 * Удаление.
	 * @param int|array $id Id записи для удаления.
	 * @return bool Вернет булево значение успешности операции.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function destroy($id);
}