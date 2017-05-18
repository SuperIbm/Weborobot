<?php
/**
 * Деревья в виде строки.
 * Этот пакет содержит классы для работы и реализации древовидных структур, генерирующиеся в строковом виде.
 * @package App.Models.Tree.Str
 */
namespace App\Models\Tree\Str;

use App\Models\Tree\Tree;


/**
 * Трей для проектирования древовидной структуры в виде строки.
 * Специализированный трейт для расширения модели чтобы он начал работать с поддержкой древовидной структуры генерирующий строку.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait TreeString
{
use Tree;

/**
 * Название начального тэга.
 * @var string
 * @since 1.0
 */
private static $_tagStart = "ul";

/**
 * Название конечного тэга.
 * @var string
 * @since 1.0
 */
private static $_tagEnd = "ul";


	/**
	 * Установка начального тэга.
	 * @param string $tag Название начального тэга.
	 * @return void
	 * @since 1.0
	 */
	public static function setTagStart($tag)
	{
	self::$_tagStart = $tag;
	}
	
	
	/**
	 * Получение начального тэга.
	 * @return string Название начального тэга.
	 * @since 1.0
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
	 */
	public static function setTagEnd($tag)
	{
	self::$_tagEnd = $tag;
	}
	
	
	/**
	 * Получение конечного тэга.
	 * @return string Название конечного тэга.
	 * @since 1.0
	 */
	public static function getTagEnd()
	{
	return self::$_tagEnd;
	}

	/**
	 * Метод рендеринга древовидной структуры.
	 * @param array $data Данные, на основе которых строится древовидная структура.
	 * @return mixed Возвращает древовидую структуру.
	 * @since 1.0
	 * @version 1.0
	 * @see \App\Models\Tree\Tree::_renderer
	 */
	protected function _renderer($data)
	{
	$root = $this->getIdRoot() == null ? ($this->getReferenRoot() == null ? 0 : $this->getReferenRoot()) : $this->getIdRoot();
	$Nodes = $this->_getDataNode($this->getNode(), $data, $root);
	$this->_setNodes($Nodes);
	return $this->_getDataString($Nodes);
	}
	
	
	/**
	 * Проектирование древовидной структуры в виде строки.
	 * @param \App\Models\Tree\Node $Nodes Древовидный узел из которого будет строится строка древовидной структуры.
	 * @return string Возвращает HTML строки древовидной структуры.
	 * @since 1.0
	 */
	private function _getDataString($Nodes)
	{
	/**
	 * @var $childrens \App\Models\Tree\Str\NodeString[]
	 * @var $Node \App\Models\Tree\Str\NodeString
	 */
	$data = "";
	$childrens = $Nodes->getChildrens();
	$Node = $this->getNode();

		if($childrens)
		{
			if(self::getTagStart() != "") $data .= "<".self::getTagStart().">\n";

			for($i = 0; $i < count($childrens); $i++)
			{
			$result = $childrens[$i]->getResults();

				if($Node::getTagStart()) $data .= "<".$Node::getTagStart().">".$result[$Node::getNameValue()];
				else $data .= $result[$Node::getNameValue()]."\n";

				if($childrens[$i]->getChildrens())
				{
				$dataChildren = $this->_getDataString($childrens[$i]);

					if($dataChildren) $data .= $dataChildren;
				}

				if($Node::getTagEnd()) $data .= "</".$Node::getTagEnd().">\n";
			}

			if(self::getTagEnd() != "") $data .= "</".self::getTagEnd().">\n";
		}

	return $data;
	}
}
?>