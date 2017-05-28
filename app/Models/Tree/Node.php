<?php
/**
 * Деревья.
 * Этот пакет содержит классы для работы и реализации древовидных структур.
 * @package App.Models.Tree
 */
namespace App\Models\Tree;


/**
 * Класс позволяющий проектировать собственный узел древовидной структуры.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Node
{
/**
 * Массив данных которые нужно отрендерить.
 * @var array
 * @since 1.0
 * @version 1.0
 */
private $_data = Array();

/**
 * Массив полученных данных после рендеринга.
 * @var array
 * @since 1.0
 * @version 1.0
 */
private $_result = Array();

/**
 * Параметры узла.
 * Содержит параметры которые требуются для проектирования узла.
 * @var array
 * @since 1.0
 * @version 1.0
 */
private static $_params = null;

/**
 * Родительский узел.
 * @var \App\Models\Tree\Node
 * @since 1.0
 * @version 1.0
 */
private $_Parent = null;

/**
 * Массив дочерних узлов.
 * @var array
 * @see \App\Models\Tree\Node
 * @since 1.0
 * @version 1.0
 */
private $_childrens = Array();


	/**
	 * Абстрактный метод рендеринга узла древовидной структуры.
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
	 */
	abstract protected function _renderer($id, $value, $currentBranch, $currentNode, $data);


	/**
	 * Метод рендеринга узла древовидной структуры.
	 * Он запускает рендеринг и записывает все данные.
	 * @param int $id ID узла.
	 * @param string $value Значение узла.
	 * @param bool $currentBranch Находиться ли этот узел на текущей ветке.
	 * @param bool $currentNode Является ли этот узел текущим.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function renderer($id, $value, $currentBranch, $currentNode)
	{
	$data = $this->_renderer($id, $value, $currentBranch, $currentNode, $this->getData());

		if($data) $this->setResults($data);

    return $this;
	}
	
	
	/**
	 * Установка параметров.
	 * @param array $params Параметры для проектирования узла.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public static function setParams($params)
	{
	self::$_params = $params;
	}


	/**
	 * Установка параметра по индексу.
	 * @param string $index Название параметра.
	 * @param array $params Параметры для проектирования узла.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public static function setParam($index, $params)
	{
	self::$_params[$index] = $params;
	}
	
	
	
	/**
	 * Получение параметров для узла.
	 * @param string $index Название параметра. Если не указать вернет все параметры.
	 * @param mixed $default Если параметр не задан, то вернуть это значение по умолчанию.
	 * @return mixed Параметр для узла.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getParams($index = null, $default = null)
	{
		if($index)
		{
			if(isset(self::$_params[$index])) return self::$_params[$index];
			else
			{
				if(@function_exists($default)) return call_user_func_array($default, array());
				else if(isset($default)) return $default;
				else return null;
			}
		}
		else return self::$_params;
	}


	/**
	 * Получение родительского узла.
	 * @return \App\Models\Tree\Node Родительский узел.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getParent()
	{
	return $this->_Parent;
	}

	/**
	 * Установка родительского узла.
	 * @param \App\Models\Tree\Node $Node Родительский узел.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function setParent(Node $Node)
	{
	$this->_Parent = $Node;
	return $this;
	}

	/**
	 * Установка результатов после рендеринга.
	 * @param array $data Массив данных после рендеринга.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function setResults($data)
	{
	$this->_result = $data;
	return $this;
	}

	/**
	 * Установка результата после рендеринга.
	 * @param string $index Название индекса куда нужно установить данные.
	 * @param array $data Массив данных после рендеринга.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function setResult($index, $data)
	{
		if(isset($index)) $this->_result[$index] = $data;
		else $this->_result = $data;

		return $this;
	}

	/**
	 * Получение данных после рендеринга.
	 * @param string $index Название индекса данных. Если не указать, то вернет все данные.
	 * @param mixed $default Если результат не задан, то вернет это значение по умолчанию.
	 * @return array Массив данных после рендеринга.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getResults($index = null, $default = null)
	{
		if($index)
		{
			if(isset($this->_result[$index])) return $this->_result[$index];
			else
			{
				if(@function_exists($default)) return call_user_func_array($default, array());
				else if(isset($default)) return $default;
				else return null;
			}
		}
		else return $this->_result;
	}


	/**
	 * Установка данных которые нужно отрендерить.
	 * @param array $data Массив данных которые нужно отрендерить.
	 * @param string $index Название индекса куда нужно установить данные.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function setData($data, $index = null)
	{
		if(isset($index)) $this->_data[$index] = $index;
		else $this->_data = $data;

	return $this;
	}

	/**
	 * Получение данных которые нужно отрендерить.
	 * @param string $index Название индекса данных.
	 * @return array Массив данных которые нужно отрендерить.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getData($index = null)
	{
		if(isset($index)) return $this->_data[$index];
		else return $this->_data;
	}


	/**
	 * Добавление дочернего узла.
	 * @param \App\Models\Tree\Node $Node Дочерний узел.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function addChildren(Node $Node)
	{
	$this->_childrens[] = $Node;
	return $this;
	}

	/**
	 * Установка дочернего узла по его индексу.
	 * @param int $index Номер индекса узла.
	 * @param \App\Models\Tree\Node $Node Дочерний узел.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function setChildren($index, Node $Node)
	{
	$this->_childrens[$index] = $Node;
	return $this;
	}

	/**
	 * Получение дочерних узлов.
	 * @param int $index Если указать индекс, то вернет только узел этого индекса.
	 * @return array|\App\Models\Tree\Node Объект дочернего узла.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getChildrens($index = null)
	{
		if(isset($index)) return $this->_childrens[$index];
		else return $this->_childrens;
	}


	/**
	 * Удаление дочерних узлов.
	 * @param int $index Если указать индекс, то удалит только узел этого индекса.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function deleteChildrens($index = null)
	{
		if(isset($index))
		{
		$childrens = Array();

			for($i = 0, $z = 0; $i < count($this->_childrens); $i++)
			{
				if($i != $index)
				{
				$childrens[$z] = $this->_childrens[$i];
				$z++;
				}
			}
		}
		else $this->_childrens = Array();

	return $this;
	}
}
?>