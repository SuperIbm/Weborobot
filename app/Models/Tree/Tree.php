<?php
/**
 * Деревья.
 * Этот пакет содержит классы для работы и реализации древовидных структур.
 * @package App.Models.Tree
 */
namespace App\Models\Tree;

use App\Models\Repositary;


/**
 * Трейт для проектирования древовидной структуры.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait Tree
{
/**
 * Объект узла для проектирование дерева.
 * @var \App\Models\Tree\Node
 * @since 1.0
 * @version 1.0
 */
private $_Node;

/**
 * ID корня ветки, что определяет, откуда начинается древовидная структура.
 * @var int
 * @since 1.0
 * @version 1.0
 */
private $_idRoot;

/**
 * ID ссылки корня ветки, что определяет, откуда начинается древовидная структура.
 * @var int
 * @since 1.0
 * @version 1.0
 */
private $_referenRoot;

/**
 * ID ветки текущего положения.
 * @var int
 * @since 1.0
 * @version 1.0
 */
private $_idCurrent;

/**
 * Открытая ли эта древовидная структура.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
private $_openType = true;

/**
 * Узел, из которого уже построено дерево.
 * @var \App\Models\Tree\Node
 * @since 1.0
 * @version 1.0
 */
private $_Nodes;


	/**
	 * Абстрактный метод получения объекта узла.
	 * @return \App\Models\Tree\Node Объект узла древовидной структуры.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract protected function _getNodeObject();


	/**
	 * Абстрактный метод рендеринга древовидной структуры.
	 * @param array $data Данные, на основе которых строится древовидная структура.
	 * @return mixed Возвращает древовидую структуру.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract protected function _renderer($data);
	
	
	/**
	 * Метод получения названия столбца определяющий название в узле.
	 * @return string Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameValue()
	{
	return "text";
	}
	
	
	/**
	 * Метод получения названия столбца определяющий вес узла.
	 * @return string Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameWeight()
	{
	return null;
	}
	
	/**
	 * Получение названия столбца определяющего ID ссылки на предыдущий узел.
	 * @return string Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameReferen()
	{
	return null;
	}
	
	
	/**
	 * Определяет, нужно ли производить автоинкремент для веса узла.
	 * @return bool Возвращает статус автоинкрементности.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getAutoIncrement()
	{
	return true;
	}


	/**
	 * Проектирование древовидной структуры в виде узла.
	 * @param \App\Models\Tree\Node|\App\Models\Tree\Arr\NodeArray $Node Объект корневого узла, который будет содержать все дочерние узлы.
	 * @param array $data Данные, на основе которых строится древовидная структура.
	 * @param int $idCurrent ID текущего узла, который мы строим.
	 * @param \App\Models\Tree\Node $NodeParent Объект родительского узла.
	 * @return \App\Models\Tree\Node Возвращает узел древовидной структуры, состоящий из объектов узлов \App\Models\Tree\Node.
	 * @since 1.0
	 * @version 1.0
	 */
	protected function _getDataNode(Node $Node, $data, $idCurrent = null, Node $NodeParent = null)
	{
	/**
	 * @var $NodeChildren \App\Models\Tree\Node
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
		for($i = 0; $i < count($data); $i++)
		{
			if(@$data[$i][self::getNameReferen()] == $idCurrent)
			{
				if($this->getIdCurrent() == @$data[$i][$this->getKeyName()]) $currentNode = true;
				else $currentNode = false;

			$currentBranch = $this->isCurrentBranch(@$data[$i][$this->getKeyName()], null, $data);

			$NameClassNode = get_class($this->getNode());
			$NodeChildren = new $NameClassNode;
			$NodeChildren->setData($data[$i]);

				if($NodeParent) $NodeChildren->setParent($Node);

			$status = $NodeChildren->renderer(@$data[$i][$this->getKeyName()], @$data[$i][self::getNameValue()], $currentBranch, $currentNode);

				if($status)
				{
				$Node->addChildren($NodeChildren);
				$nodeValue = $NodeChildren->getResults();

					if
					(
						(@$data[$i][$this->getKeyName()] && $this->isOpenType() == true) ||
						(@$data[$i][$this->getKeyName()] && $this->isOpenType() == false && $currentBranch == true) ||
						(@$data[$i][$this->getKeyName()] && $this->isOpenType() == false && (@$nodeValue[$Node::getNameCurrentNode()] == true || @$nodeValue[$Node->getNameCurrentBranch()] == true))
					)
					{
					$this->_getDataNode($NodeChildren, $data, @$data[$i][$this->getKeyName()], $Node);
					}
				}
			}
		}

	return $Node;
	}


	/**
	 * Возвращает узел из которого будет строится дерево.
	 * Этот узел формируется после запуска \App\Models\Tree::_renderer и состоит из объекта \App\Models\Tree\Node, что содержит все дочерние объекты.
	 * @return \App\Models\Tree\Node Объект узла.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getNodes()
	{
	return $this->_Nodes;
	}


	/**
	 * Устанавливает узел из которого будет строится дерево.
	 * Этот узел формируется после запуска \App\Models\Tree::_renderer и состоит из объекта \App\Models\Tree\Node, что содержит все дочерние объекты.
	 * @param \App\Models\Tree\Node $Nodes Узел для стротельства.
	 * @return \App\Models\Tree\Node Объект узла.
	 * @since 1.0
	 * @version 1.0
	 */
	private function _setNodes(Node $Nodes)
	{
	$this->_Nodes = $Nodes;
	return $this->_Nodes;
	}


	/**
	 * Создание нового узла.
	 * @param array $data Данные для построения узла.
	 * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
	 * @since 1.0
	 * @version 1.0
	 */
	public function createNode($data, $filters = null)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 * @var $Model \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
	$nameWeight = self::getNameWeight();

		if($nameWeight)
		{
		$Query = $this->newInstance()->newQuery();

			if(self::getNameReferen() && isset($data[self::getNameReferen()]))
			{
			$Query->where(self::getNameReferen(), $data[self::getNameReferen()]);
			}

            if($filters)
            {
            $fils = Repositary::filters($filters, $this->newInstance()->getFillable(), $Query->getTable());

                for($i = 0; $i < count($fils); $i++)
                {
                $Query->where($fils[$i]['property'], !isset($fils[$i]['operator']) ? "=" : $fils[$i]['operator'], $fils[$i]['value']);
                }
            }

		$Query->orderBy(self::getNameWeight(), "desc");
		$NodeLast = $Query->first();

			if(self::getAutoIncrement() == true)
			{
				if($NodeLast)
				{
                $nodeLast = $NodeLast->toArray();

					if(isset($nodeLast[$nameWeight]) && (is_integer($nodeLast[$nameWeight]) || is_numeric($nodeLast[$nameWeight])))
					{
					$data[$nameWeight] = $nodeLast[$nameWeight] + 1;
					}
				}
				else $data[$nameWeight] = 0;
			}
		}

	$Model = $this->newInstance();
    unset($data[$Model->getKeyName()]);
	$Model = $Model->create($data);

		if($Model->hasError())
		{
		$this->addError($Model->getErrors());
		return false;
		}
		else return $Model->getKeyName();
	}

    /**
     * Удаление данных согласно внесенным параметрам, с возможностью выбора удалять потомки или сохранить их.
     * @param int|array $id Массив ID которых нужно удалить.
     * @param bool $destroyChildren Определяет нужно ли производить удаление внутренних узлов.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
     * @return bool Вернет успешность удаления данных.
     * @since 1.0
     * @version 1.0
     */
	protected function _destroyNode($id, $destroyChildren = true, $filters = null)
    {
    /**
     * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
     */
    $DeleteNodes = [];

        if(!is_array($id)) $id = [$id];

        for($i = 0; $i < count($id); $i++)
        {
        $Node = $this->newInstance()->find($id[$i]);

            if($Node) $DeleteNodes[] = $Node;
        }

    $nameWeight = self::getNameWeight();
    $nameReferen = self::getNameReferen();

        for($i = 0; $i < count($DeleteNodes); $i++)
        {
        $attrs = $DeleteNodes[$i]->toArray();

            if(is_integer($attrs[$nameWeight]) || is_numeric($attrs[$nameWeight]))
            {
                if(self::getNameReferen())
                {
                    $NodesShift = $this->newInstance()
                    ->newQuery()
                    ->where(self::getNameWeight(), ">", $attrs[$nameWeight])
                    ->where(self::getNameReferen(), "=", $attrs[$nameReferen]);
                }
                else
                {
                    $NodesShift = $this->newInstance()
                    ->newQuery()
                    ->where(self::getNameWeight(), ">", $attrs[$nameWeight]);
                }

                if($filters)
                {
                $fils = Repositary::filters($filters, $this->newInstance()->getFillable(), $this->newInstance()->getTable());

                    for($z = 0; $z < count($fils); $z++)
                    {
                    $NodesShift->where($fils[$z]['property'], !isset($fils[$z]['operator']) ? "=" : $fils[$z]['operator'], $fils[$z]['value']);
                    }
                }

                if($NodesShift)
                {
                $NodesShift = $NodesShift->get();

                    for($z = 0; $z < count($NodesShift); $z++)
                    {
                    $NodesShift[$z]->$nameWeight -= 1;
                    $NodesShift[$z]->save();
                    }
                }
            }

            if(self::getNameReferen() && $destroyChildren == true)
            {
                $nodesDeleteParent = $this->newInstance()
                ->newQuery()
                ->where(self::getNameReferen(), "=", $attrs[$this->getKeyName()])
                ->get()
                ->toArray();

                if($nodesDeleteParent)
                {
                $idsDelete = [];

                    for($z = 0; $z < count($nodesDeleteParent); $z++)
                    {
                    $idsDelete[$z] = $nodesDeleteParent[$z][$this->getKeyName()];
                    }

                $this->newInstance()->deleteNode($destroyChildren, $idsDelete, $filters);
                }
            }

        $DeleteNodes[$i]->delete();
        }

    return true;
    }

	/**
	 * Удаление узла с возможностью выбора удалять потомки или сохранить их.
	 * @param bool $destroyChildren Определяет нужно ли производить удаление внутренних узлов.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
	 * @return bool Вернет успешность удаления узла.
	 * @since 1.0
	 * @version 1.0
	 */
	public function deleteNode($destroyChildren = true, $filters = null)
	{
    /**
     * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
     */
	return $this->_destroyNode([$this->getKey()], $destroyChildren, $filters);
	}


    /**
     * Удаление узла согласно внесенным параметрам, с возможностью выбора удалять потомки или сохранить их.
     * @param int|array $id Массив ID который нужно удалить.
     * @param bool $destroyChildren Определяет нужно ли производить удаление внутренних узлов.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
     * @return bool Вернет успешность удаления узла.
     * @since 1.0
     * @version 1.0
     */
    public function destroyNode($id, $destroyChildren = true, $filters = null)
    {
    return $this->_destroyNode($id, $destroyChildren, $filters);
    }


	/**
	 * Установка нового веса узла в древовидной структуре.
	 * @param int $weightNew Новый вес узла.
	 * @param int $id ID узла, который нужно переместить, если не указать, то переместит модель взятую с базы данных.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
	 * @return bool Возвращает успешность перемещения.
	 * @since 1.0
	 * @version 1.0
	 */
	public function setWeight($weightNew, $id = null, $filters = null)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
		if(self::getAutoIncrement() == true && self::getNameWeight())
		{
		$NodeMove = $id == null ? $this : $this->find($id);

			if($NodeMove)
			{
			$attrs = $NodeMove->toArray();
			$nameWeight = self::getNameWeight();
			$weightOld = $attrs[$nameWeight];

				if($weightOld != $weightNew)
				{
				$Model = $this->newInstance()->newQuery();

				    if($filters)
                    {
                    $fils = Repositary::filters($filters, $this->newInstance()->getFillable(), $this->newInstance()->getTable());

                        for($i = 0; $i < count($fils); $i++)
                        {
                        $Model->where($fils[$i]['property'], !isset($fils[$i]['operator']) ? "=" : $fils[$i]['operator'], $fils[$i]['value']);
                        }
                    }

					if($weightOld < $weightNew) // Идем вниз
					{
						$Model = $Model
						->where($nameWeight, ">", $weightOld)
						->where($nameWeight, "<=", $weightNew);

						if(self::getNameReferen()) $Model = $Model->where(self::getNameReferen(), "=", $attrs[self::getNameReferen()]);

					$NodesShift = $Model->get();
					}
					else // Идем вверх
					{
						$Model = $Model
						->where($nameWeight, "<", $weightOld)
						->where($nameWeight, ">=", $weightNew);

						if(self::getNameReferen()) $Model = $Model->where(self::getNameReferen(), "=", $attrs[self::getNameReferen()]);

					$NodesShift = $Model->get();
					}

					for($i = 0; $i < count($NodesShift); $i++)
					{
						if($weightOld < $weightNew) $NodesShift[$i]->$nameWeight -= 1;
						else if($weightOld > $weightNew) $NodesShift[$i]->$nameWeight += 1;

					$NodesShift[$i]->save();
					}

				$NodeMove->$nameWeight = $weightNew;
				$NodeMove->save();
				}

			return true;
			}
			else return false;
		}
		else return false;
	}



	/**
	 * Установка нового положение узла в древовидной структуре.
	 * @param int $idReferenNew ID узла, которому должен принадлежал этот узел.
	 * @param int $id ID узла, который нужно переместить, если не указать, то переместит модель взятую с базы данных.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
	 * @return bool Возвращает успешность перемещения.
	 * @since 1.0
	 * @version 1.0
	 */
	public function setPosition($idReferenNew, $id = null, $filters = null)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
		if(self::getNameReferen())
		{
		$NodeMove = $id == null ? $this : $this->find($id);

			if($NodeMove)
			{
			$attrs = $NodeMove->toArray();
			$nameReferen = self::getNameReferen();
			$idReferenOld = $attrs[$nameReferen];

				if($idReferenOld != $idReferenNew)
				{
					if(self::getNameWeight() && self::getAutoIncrement() == true)
					{
					$nameWeight = self::getNameWeight();

						$NodesShift = $this->newInstance()
						->newQuery()
						->where($nameWeight, ">=", $attrs[self::getNameWeight()])
						->where(self::getNameReferen(), "=", $idReferenOld);

                        if($filters)
                        {
                        $fils = Repositary::filters($filters, $this->newInstance()->getFillable(), $this->newInstance()->getTable());

                            for($i = 0; $i < count($fils); $i++)
                            {
                            $NodesShift->where($fils[$i]['property'], !isset($fils[$i]['operator']) ? "=" : $fils[$i]['operator'], $fils[$i]['value']);
                            }
                        }

                    $NodesShift = $NodesShift->get();

						for($i = 0; $i < count($NodesShift); $i++)
						{
						$NodesShift[$i]->$nameWeight -= 1;
						$NodesShift[$i]->save();
						}

						$NodeLast = $this->newInstance()
						->newQuery()
						->where(self::getNameReferen(), $idReferenNew)
						->orderBy(self::getNameWeight(), "desc");

                        if($filters)
                        {
                        $fils = Repositary::filters($filters, $this->newInstance()->getFillable(), $this->newInstance()->getTable());

                            for($i = 0; $i < count($fils); $i++)
                            {
                            $NodeLast->where($fils[$i]['property'], !isset($fils[$i]['operator']) ? "=" : $fils[$i]['operator'], $fils[$i]['value']);
                            }
                        }

                    $nodeLast = $NodeLast->first();

                        if($nodeLast)
                        {
                        $nodeLast = $nodeLast->toArray();

                            if(isset($nodeLast[$nameWeight]) && (is_integer($nodeLast[$nameWeight]) || is_numeric($nodeLast[$nameWeight])))
                            {
                            $NodeMove->$nameWeight = $nodeLast[$nameWeight] + 1;
                            }
                        }
                        else $NodeMove->$nameWeight = 0;
					}

				$NodeMove->$nameReferen = $idReferenNew;
				$NodeMove->save();
				}

			return true;
			}
			else return false;
		}
		else return false;
	}



	/**
	 * Установка корня ветки согласно введенному ID узла.
	 * @param int $id ID узла.
	 * @return bool Возвращает успешность операции.
	 * @since 1.0
	 * @version 1.0
	 */
	public function setIdRoot($id)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
	$Model = $this->newInstance()->find($id);

		if($Model)
		{
		$this->_idRoot = $id;
		$this->_referenRoot = $Model->toArray()[self::getNameReferen()];
		return true;
		}
		else return false;
	}


	/**
	 * Установка корня ветки согласно введенному ID ссылки узла.
	 * @param int $id ID ссылки узла.
	 * @return bool Возвращает успешность операции.
	 * @since 1.0
	 * @version 1.0
	 */
	public function setReferenRoot($id)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
	$Model = $this->newInstance()->newQuery();

		$data = $Model->where(self::getNameReferen(), $id)
		->first()
		->toArray();

		if($data)
		{
		$this->_idRoot = null;
		$this->_referenRoot = $id;
		return true;
		}
		else return false;
	}


	/**
	 * Получение ID корня ветки.
	 * @return int Получение ID корня ветки.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getIdRoot()
	{
		if($this->_idRoot) return $this->_idRoot;
		else return null;
	}


	/**
	 * Получение ID ссылки корня ветки.
	 * @return int Получение ID ссылки корня ветки.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getReferenRoot()
	{
		if($this->_referenRoot) return $this->_referenRoot;
		else return null;
	}


	/**
	 * Установка ID текущего положения пользователя.
	 * @param int $id ID узла.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function setIdCurrent($id)
	{
	$this->_idCurrent = $id;
	return $this;
	}


	/**
	 * Получение ID текущего положения пользователя.
	 * @return int ID узла.
	 * @return int ID текущего положения пользователя.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getIdCurrent()
	{
	return $this->_idCurrent;
	}


	/**
	 * Получение объекта узла.
	 * @return \App\Models\Tree\Node Объект узла древовидной структуры.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getNode()
	{
		if($this->_Node) return $this->_Node;
		else return $this->_getNodeObject();
	}


	/**
	 * Установка объекта узла.
	 * @param \App\Models\Tree\Node $Node Объект узла.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function setNode(Node $Node)
	{
	$this->_Node = $Node;
	return $this;
	}



	/**
	 * Получение и установка открытая или закрытая ли это древовидная структура.
	 * Если указать true, то древовидная структура будет открытой, если указать false, то закрытой.
	 * @param bool $status Статус на открытость или закрытость.
	 * @return mixed Может вернуть текущее значение, или $this.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isOpenType($status = null)
	{
		if(!isset($status)) return $this->_openType;
		else
		{
		$this->_openType = $status;
		return $this;
		}
	}


	/**
	 * Получение древовидной структуры.
	 * @param array $data Данные для построения узла, если не указать, возьмет сам.
	 * @return mixed Получение древовидной структуры.
	 * @since 1.0
	 * @version 1.0
	 */
	public function tree($data = null)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
	$data = isset($data) ? $data : $this->get();
	return $this->_renderer($data);
	}



	/**
	 * Получение пути от заданного корня до последней ветки.
	 * Получаем путь в виде массива, где началом служит заданный корень, а концом служит конечная ветка.
	 * @param int $idRoot ID корня ветки, с которой мы идем.
	 * @param string $columnValue Название столбца с которого берется значение, если не указать будет брать весь массив данных узла.
	 * @param array $data Данные полученные с выборки для построения пути, если не указать возьмет их сам.
	 * @return mixed Массив пути от заданного корня до последней ветки.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getPathByRoot($idRoot = null, $columnValue = null, $data = null)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
	$data = $data == null ? $this->get()->toArray() : $data;
	$path = Array();

		for($i = 0; $i < count($data); $i++)
		{
			if(isset($data[$i][$this->getKeyName()]) && $data[$i][$this->getKeyName()] == $idRoot)
			{
				if($columnValue && isset($data[$i][$columnValue])) $path[0] = $data[$i][$columnValue];
				else $path[0] = $data[$i];

			break;
			}
		}

	$pathNext = $this->_getPathByRoot($idRoot, $columnValue, $data);

		if($pathNext) $path = array_merge($path, $pathNext);

	return $path;
	}


	/**
	 * Выборка данных для получения пути от заданного корня до последней ветки.
	 * @param int $idRoot ID корня ветки, с которой мы идем.
	 * @param array $data Данные полученные с выборки для построения пути, если не указать возьмет их сам.
	 * @param string $columnValue Название столбца, который будет служить для именования узлов.
	 * @return mixed Массив пути от заданного корня до последней ветки.
	 * @since 1.0
	 * @version 1.0
	 */
	private function _getPathByRoot($idRoot, $columnValue, $data)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
	$path = Array();

		for($i = 0; $i < count($data); $i++)
		{
			if(isset($data[$i][self::getNameReferen()]) && $data[$i][self::getNameReferen()] == $idRoot)
			{
			$ln = count($path);

				if($columnValue && isset($data[$i][$columnValue])) $path[$ln] = $data[$i][$columnValue];
				else $path[$ln] = $data[$i];

				if(isset($data[$i][$this->getKeyName()]))
				{
				$pathNext = $this->_getPathByRoot($data[$i][$this->getKeyName()], $columnValue, $data);

					if($pathNext) $path = array_merge($path, $pathNext);
				}
			}
		}

	return $path;
	}


	/**
	 * Получение пути от заданной ветки до заданного корня.
	 * Получаем путь в виде массива, где началом служит заданная ветка, а концом служит заданный корень.
	 * @param int $id ID ветки, от которой мы идем.
	 * @param int $idRoot ID корня ветки, до которого мы идем.
	 * @param string $columnValue Название столбца, который будет служить для именования узлов, если не указать будет брать весь массив данных узла.
	 * @param array $data Данные полученные с выборки для построения пути, если не указать возьмет их сам.
	 * @return mixed Массив пути от ветки до заданного корня.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getPath($id, $idRoot = null, $columnValue = null, $data = null)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
	$data = $data == null ? $this->get()->toArray() : $data;
	$path = $this->_getPath($id, $idRoot, $columnValue, $data);

		if($path) $path = array_reverse($path);

	return $path;
	}


	/**
	 * Выборка данных для получения пути от заданной ветки до заданного корня.
	 * @param int $id ID ветки, от которой мы идем.
	 * @param int $idRoot ID корня ветки, до которого мы идем.
	 * @param string $columnValue Название столбца, который будет служить для именования узлов, если не указать будет брать весь массив данных узла.
	 * @param array $data Данные полученные с выборки для построения пути.
	 * @return mixed Массив пути от ветки до заданного корня.
	 * @since 1.0
	 * @version 1.0
	 */
	private function _getPath($id, $idRoot, $columnValue, $data)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
	$path = Array();

		for($i = 0; $i < count($data); $i++)
		{
			if(isset($data[$i][$this->getKeyName()]) && $data[$i][$this->getKeyName()] == $id)
			{
				if($data[$i][$this->getKeyName()] == $idRoot) return false;

			$ln = count($path);

				if($columnValue && isset($data[$i][$columnValue])) $path[$ln] = $data[$i][$columnValue];
				else $path[$ln] = $data[$i];

				if(isset($data[$i][self::getNameReferen()]))
				{
				$pathNext = $this->_getPath($data[$i][self::getNameReferen()], $idRoot, $columnValue, $data);

					if($pathNext) $path = array_merge($path, $pathNext);
				}
			}
		}

	return $path;
	}


	/**
	 * Проверка находиться ли указанный узел на текущей ветке.
	 * @param int $id ID ветки.
	 * @param int $idCurrent ID текущей ветки, если не указать, то возьмет с \App\Models\Tree::getIdCurrent.
	 * @param array $data Данные полученные с выборки для построения пути, если не указать возьмет их сам.
	 * @return bool Если true, то узел находиться на текущей ветке.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isCurrentBranch($id, $idCurrent = null, $data = null)
	{
	/**
	 * @var $this \Illuminate\Database\Query\Builder|\App\Models\Tree\Tree|\Illuminate\Database\Eloquent\Model
	 */
	$idCurrent = isset($idCurrent) ? $idCurrent : $this->getIdCurrent();
	$path = $this->getPath($idCurrent, null, $this->getKeyName(), $data);

		if($path)
		{
			for($i = 0; $i < count($path); $i++)
			{
				if($path[$i] == $id) return true;
			}
		}

	return false;
	}
}
?>