<?php
/**
 * Модуль Компонента страницы.
 * Этот модуль содержит все классы для работы с компонентами страницы.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponent\Repositories;

/**
 * Абстрактный класс построения репозитария в виде древовидной структуры выдающий массив.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class PageComponentTreeArray extends PageComponent
{
	/**
	 * Чтение данных и получение их в виде древовидной структуры.
	 * @param array $data Данные для построения дерева.
	 * @param bool $isOpenType Определяем является ли эта закрытая или открытая древовидная структура.
	 * @param int $idCurrent ID корень текущей ветки.
	 * @param int $idRoot ID корень ветки.
	 * @param int $idReferenRoot ID ссылки узла для установки корня ветки.
     * @param array $params Параметры для узла.
	 * @return array Построенное дерево.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function tree($data, $isOpenType = true, $idCurrent = null, $idRoot = null, $idReferenRoot = null, $params = null);


	/**
	 * Установка нового веса узла в древовидной структуре.
	 * @param int $id ID узла, который нужно переместить.
	 * @param int $weight Новый вес узла.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
	 * @return bool Возвращает успешность перемещения.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function setWeight($id, $weight, $filters = null);


	/**
	 * Установка нового положение узла в древовидной структуре.
	 * @param int $id ID узла, который нужно переместить.
	 * @param int $idReferenNew ID узла, которому должен принадлежал этот узел.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
	 * @return bool Возвращает успешность перемещения.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function setPosition($id, $idReferenNew, $filters = null);
}
?>