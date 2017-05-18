<?php
/**
 * Деревья в виде строки.
 * Этот пакет содержит классы для работы и реализации древовидных структур, генерирующиеся в строковом виде.
 * @package App.Models.Tree.Str
 */
namespace App\Models\Tree\Str;

use App\Models\Tree\Arr\NodeArray;


/**
 * Абстрактный класс для проектирования узла древовидной структуры в виде строки.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class NodeString extends NodeArray
{
/**
 * Название начального тэга.
 * @var string
 * @since 1.0
 * @version 1.0
 */
private static $_tagStart = "li";

/**
 * Название конечного тэга.
 * @var string
 * @since 1.0
 * @version 1.0
 */
private static $_tagEnd = "li";

/**
 * Название css класса текущего узла.
 * @var string
 * @since 1.0
 * @version 1.0
 */
private static $_classCurrent = "current";


	/**
	 * Установка начального тэга.
	 * @param string $tag Название начального тэга.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public static function setTagStart($tag)
	{
	self::$_tagStart = $tag;
	}
	
	
	/**
	 * Получение начального тэга.
	 * @return string Название начального тэга.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getTagStart()
	{
	return self::$_tagStart;
	}
	
	
	/**
	 * Установка конечного тэга.
	 * @param string $tag Название конечного тэга.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public static function setTagEnd($tag)
	{
	self::$_tagEnd = $tag;
	}
	
	
	/**
	 * Получение конечного тэга.
	 * @return string Название конечного тэга.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getTagEnd()
	{
	return self::$_tagEnd;
	}
	
	
	/**
	 * Установка css класса текущего узла.
	 * @param string $classCurrent Название класса.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public static function setСlassCurrent($classCurrent)
	{
	self::$_classCurrent = $classCurrent;
	}
	
	
	/**
	 * Получение css класса текущего узла.
	 * @return string Название класса.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getСlassCurrent()
	{
	return self::$_classCurrent;
	}
}
?>