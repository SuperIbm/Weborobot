<?php
/**
 * Деревья в виде строки.
 * Этот пакет содержит классы для работы и реализации древовидных структур, генерирующиеся в строковом виде.
 * @package App.Models.Tree.Str
 */
namespace App\Models\Tree\Str;

use Util;

/**
 * Класс для проектирования узла древовидной структуры в виде строки с переводом каретки к тэгу &lt;br /&gt; и удаление HTML разметки.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class NodeStringTextN extends NodeString
{
	/**
	 * Метод рендеринга узла древовидной структуры.
	 * @param int $id ID узла.
	 * @param string $value Значение узла.
	 * @param bool $currentBranch Находиться ли этот узел на текущей ветке.
	 * @param bool $currentNode Является ли этот узел текущим.
	 * @param array $data Все данные этого узла.
	 * @return array Возвращает массив данных узла древовидной структуры. Где индексы должны строится так:
	 * <ul>
	 * 	<li>NodeArray::getNameId() - Получение индекса ID узла</li>
	 * 	<li>NodeArray::getNameValue() - Получение индекса значения узла</li>
	 * 	<li>NodeArray::getNameCurrentNode() - Получение индекса, что хранит статус, является ли это узел текущим.</li>
	 * 	<li>NodeArray::getNameCurrentBranch() - Получение индекса, что хранит статус, находится ли этот узел на текущей ветке.</li>
	 * </ul>
	 * Допустимо включать и другие индексы, помимо тех, которые указаны здесь как обязательные.
	 * @since 1.0
	 * @version 1.0
	 * @see \App\Models\Tree\Node::_renderer
	 */
	protected function _renderer($id, $value, $currentBranch, $currentNode, $data)
	{
		return array
		(
		self::getNameId() => $id,
		self::getNameValue() => Util::getTextN($value),
		self::getNameCurrentNode() => $currentNode,
		self::getNameCurrentBranch() => $currentBranch
		);
	}
}
?>