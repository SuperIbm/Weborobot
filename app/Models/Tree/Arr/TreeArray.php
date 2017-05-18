<?php
/**
 * Деревья в виде массива.
 * Этот пакет содержит классы для работы и реализации древовидных структур, генерирующиеся в виде массива.
 * @package App.Models.Tree.Arr
 */
namespace App\Models\Tree\Arr;

use App\Models\Tree\Tree;
use App\Models\Tree\Node;


/**
 * Трей для проектирования древовидной структуры в виде массива.
 * Специализированный трейт для расширения модели, чтобы он начал работать с поддержкой древовидной структуры генерирующий массив.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait TreeArray
{
use Tree;

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
	return $this->_getDataAr($Nodes);
	}


	/**
	 * Проектирование древовидной структуры в виде массива.
	 * @param \App\Models\Tree\Node $Nodes Древовидный узел из которого будет строится массив древовидной структуры.
	 * @return array Возвращает массив древовидной структуры.
	 * @since 1.0
	 * @version 1.0
	 */
	protected function _getDataAr(Node $Nodes)
	{
	/**
	 * @var $childrens \App\Models\Tree\Arr\NodeArray[]
	 */
	$data = Array();
	$childrens = $Nodes->getChildrens();

		if($childrens)
		{
			for($i = 0; $i < count($childrens); $i++)
			{
			$data[$i] = $childrens[$i]->getResults();

				if($childrens[$i]->getChildrens()) $data[$i][$childrens[$i]::getNameChildren()] = $this->_getDataAr($childrens[$i]);
				else $data[$i][$childrens[$i]::getNameChildren()] = Array();
			}
		}

	return $data;
	}
}
?>