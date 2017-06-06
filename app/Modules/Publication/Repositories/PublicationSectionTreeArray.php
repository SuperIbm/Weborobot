<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Repositories;

/**
 * Абстрактный класс построения репозитария в виде древовидной структуры выдающий массив для разделов публикаций.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class PublicationSectionTreeArray extends PublicationSection
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
	 * @return bool Возвращает успешность перемещения.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function setWeight($id, $weight);


	/**
	 * Установка нового положение узла в древовидной структуре.
	 * @param int $id ID узла, который нужно переместить.
	 * @param int $idReferenNew ID узла, которому должен принадлежал этот узел.
	 * @return bool Возвращает успешность перемещения.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function setPosition($id, $idReferenNew);


	/**
	 * Получение пути от заданного корня до последней ветки.
	 * Получаем путь в виде массива, где началом служит заданный корень, а концом служит конечная ветка.
	 * @param array $data Данные полученные с выборки для построения пути.
	 * @param int $idRoot ID корня ветки, с которой мы идем.
	 * @param string $columnValue Название столбца с которого берется значение, если не указать будет брать весь массив данных узла.
	 * @return mixed Массив пути от заданного корня до последней ветки.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function getPathByRoot($data, $idRoot = null, $columnValue = null);


	/**
	 * Получение пути от заданной ветки до заданного корня.
	 * Получаем путь в виде массива, где началом служит заданная ветка, а концом служит заданный корень.
	 * @param array $data Данные полученные с выборки для построения пути.
	 * @param int $id ID ветки, от которой мы идем.
	 * @param int $idRoot ID корня ветки, до которого мы идем.
	 * @param string $columnValue Название столбца, который будет служить для именования узлов, если не указать будет брать весь массив данных узла.
	 * @return mixed Массив пути от ветки до заданного корня.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function getPath($data, $id, $idRoot = null, $columnValue = null);


	/**
	 * Проверка находиться ли указанный узел на текущей ветке.
	 * @param array $data Данные полученные с выборки для построения пути.
	 * @param int $id ID ветки.
	 * @param int $idCurrent ID текущей ветки.
	 * @return bool Если true, то узел находиться на текущей ветке.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function isCurrentBranch($data, $id, $idCurrent);
}
?>