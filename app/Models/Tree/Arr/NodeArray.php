<?php
/**
 * Деревья в виде массива.
 * Этот пакет содержит классы для работы и реализации древовидных структур, генерирующиеся в виде массива.
 * @package App.Models.Tree.Arr
 */
namespace App\Models\Tree\Arr;

use App\Models\Tree\Node;


/**
 * Абстрактный класс для проектирования узла в виде массива древовидной структуры.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class NodeArray extends Node
{
/**
 * Название индекса, который будет хранить ID узла.
 * @var string
 * @since 1.0
 * @version 1.0
 */
private static $_nameId = "id";

/**
 * Название индекса, который будет хранить значение узла.
 * @var string
 * @since 1.0
 * @version 1.0
 */
private static $_nameValue = "text";

/**
 * Название индекса, который будет хранить дочерние узлы.
 * @var string
 * @since 1.0
 * @version 1.0
 */
private static $_nameChildren = "children";

/**
 * Название индекса, который будет хранить статус, является ли это узел текущим.
 * @var string
 * @since 1.0
 * @version 1.0
 */
private static $_nameCurrentNode = "currentNode";

/**
 * Название индекса, который будет хранить статус, находится ли этот узел на текущей ветке.
 * @var string
 * @since 1.0
 * @version 1.0
 */
private static $_nameCurrentBranch = "currentBranch";

	/**
	 * Установка индекса ID узла.
	 * @param string $nameId Название индекса.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public static function setNameId($nameId)
	{
	self::$_nameId = $nameId;
	}
	
	
	/**
	 * Получение индекса ID узла.
	 * @return string Название индекса.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameId()
	{
	return self::$_nameId;
	}
	
	
	/**
	 * Установка индекса значения узла.
	 * @param string $nameValue Название индекса.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public static function setNameValue($nameValue)
	{
	self::$_nameValue = $nameValue;
	}
	
	
	/**
	 * Получение индекса значения узла.
	 * @return string Название индекса.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameValue()
	{
	return self::$_nameValue;
	}
	
	
	/**
	 * Установка индекса, что хранит дочерние узлы.
	 * @param string $nameChildren Название индекса.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public static function setNameChildren($nameChildren)
	{
	self::$_nameChildren = $nameChildren;
	}
	
	/**
	 * Получение индекса, что хранит дочерние узлы.
	 * @return string Название индекса.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameChildren()
	{
	return self::$_nameChildren;
	}
	
	/**
	 * Установка индекса, что хранит статус, является ли это узел текущим.
	 * @param string $nameCurrentNode Название индекса.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public static function setNameCurrentNode($nameCurrentNode)
	{
	self::$_nameCurrentNode = $nameCurrentNode;
	}
	
	
	/**
	 * Получение индекса, что хранит статус, является ли это узел текущим.
	 * @return string Название индекса.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameCurrentNode()
	{
	return self::$_nameCurrentNode;
	}
	
	/**
	 * Установка индекса, что хранит статус, находится ли этот узел на текущей ветке.
	 * @param string $nameCurrentBranch Название индекса.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public static function setNameCurrentBranch($nameCurrentBranch)
	{
	self::$_nameCurrentBranch = $nameCurrentBranch;
	}
	
	
	/**
	 * Получение индекса, что хранит статус, находится ли этот узел на текущей ветке.
	 * @return string Название индекса.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameCurrentBranch()
	{
	return self::$_nameCurrentBranch;
	}
}
?>