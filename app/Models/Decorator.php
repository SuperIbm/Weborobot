<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */
namespace App\Models;


/**
 * Абстрактный класс для проектирования декоратора.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Decorator
{
use Error, Event;

/**
 * Содержит массив всех декораторов, которые нужно выполнить.
 * @var \App\Models\Decorator[]
 * @since 1.0
 * @version 1.0
 */
private $_decorators = [];

/**
 * Родительский декоратор.
 * @var \App\Models\Decorator
 * @version 1.0
 * @since 1.0
 */
private $_DecoratorParent;

/**
 * Результат полученных данных после действий.
 * @var array
 * @version 1.0
 * @since 1.0
 */
private $_data = [];

	/**
	 * Этот абстрактный метод предназначен для проектирования собственных действий в декораторе.
	 * @return bool Должен вернуть true если действие выполнено успешно.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract protected function _action();
	
	
	/**
	 * Абстрактный метод получения индекса.
	 * Этот индекс используется в массиве данных для сохранения тех данных, которые были созданы этим декоратором.
	 * @return string Название индекса.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function getIndex();
	
	
	/**
	 * Добавление декоратора.
	 * @param \App\Models\Decorator $Decorator Объект декоратора.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function addDecorator(Decorator $Decorator)
	{
	$this->_decorators[] = $Decorator;
    $Decorator->_setParentDecorator($this);
	return $this;	
	}


    /**
     * Добавление декараторов.
     * @param \App\Models\Decorator[] $decorators Массив декораторов.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
	public function addDecorators($decorators)
    {
        if($decorators)
        {
            for($i = 0; $i < count($decorators); $i++)
            {
                if(isset($decorators[$i])) $this->addDecorator($decorators[$i]);
            }
        }

    return $this;
    }
	
	
	/**
	 * Удаление декоратора.
	 * @param \App\Models\Decorator $Decorator Объект декоратора.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function deleteDecorator(Decorator $Decorator)
	{
	$decorators = [];
	
		for($i = 0; $i < count($this->_decorators); $i++)
		{
			if($this->_decorators[$i] !== $Decorator) $decorators[] = $Decorator;
		}
	
	$this->_decorators = $decorators;
	return $this;	
	}


	/**
	 * Установка родительского декоратора.
	 * @param \App\Models\Decorator $Decorator Объект родительского декоратора.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	protected function _setParentDecorator(Decorator $Decorator)
	{
	$this->_DecoratorParent = $Decorator;
	return $this;
	}
	
	
	/**
	 * Получение родительского декоратора.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function getParentDecorator()
	{
	return $this->_DecoratorParent;	
	}


    /**
     * Получение корневого декоратора.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
	public function getRootDecorator()
    {
    return $this->_getRootDecorator($this);
    }


    /**
     * Получение корневого декоратора методом пербора всех родительских декораторов.
     * @param \App\Models\Decorator $Decorator Объект родительского декоратора.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    private function _getRootDecorator(Decorator $Decorator)
    {
        if($Decorator->getParentDecorator()) return $this->_getRootDecorator($Decorator->getParentDecorator());

    return $Decorator;
    }
	
	
	/**
	 * Установка данных декоратора.
	 * @param mixed $data Данные выработанные этим декоратором.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	protected function _setData($data)
	{
	$this->_data = $data;	
	return $this;
	}


    /**
     * Получение данных, которые были выработаны декораторомами в виде массива.
     * @return array Массив всех данных.
     * @since 1.0
     * @version 1.0
     */
	protected function _getData()
    {
    $data = [];

        if($this->_data) $data[$this->getIndex()] = $this->_data;

        for($i = 0; $i < count($this->_decorators); $i++)
        {
        $dataNew = $this->_decorators[$i]->_getData();

            if($dataNew) $data = array_merge($data, $dataNew);
        }

    return $data;
    }
	
	/**
	 * Получение данных, которые были выработаны декораторами.
	 * @param string $type Тип получаемых данных: array - в виде массива, collection - в виде коллекции.
	 * @return array Массив всех данных.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getData($type = "collection")
	{
	$data = $this->_getData();
		
		if($type == "collection") return collect($data);
		else return $data;
	}

	
	/**
	 * Запуск декоратора.
	 * @param string $type Тип получаемых данных: array - в виде массива, collection - в виде коллекции.
	 * @return mixed Возвращает полученный результат после запуска.
	 * @since 1.0
	 * @version 1.0
	 */
	public function run($type = "collection")
	{
    $this->addEvent("beforeAction");
    $this->addEvent("afterAction");

	$status = $this->untilEvent("beforeAction");
	
		if($status == true)
		{
		$status = $this->_action();
		
			if($status == true)
			{									
				if(count($this->_decorators) != 0)
				{										
					for($i = 0; $i < count($this->_decorators); $i++)
					{
					$statusCurrent = $this->_decorators[$i]->run();
					
						if($statusCurrent === false)
						{
						$status = false;
						$this->addError($this->_decorators[$i]->getErrors());
						break;
						}
					}
				}
				
				if($status == true)
				{
				$status = $this->untilEvent("afterAction", array($status));
				
					if($status === false) return false;
					else return $this->getData($type);
				}
				else return false;
			}
		}
		
	return false;	
	}


    /**
     * Установка параметра.
     * @param string $key Индекс параметра.
     * @param mixed $value Значение параметра.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
	public function setParam($key, $value)
    {
    $this->$key = $value;
    return $this;
    }

    /**
     * Установка параметров.
     * @param array $values Массив параметров.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function setParams($values)
    {
        foreach($values as $key => $value)
        {
        $this->setParam($key, $value);
        }

    return $this;
    }

    /**
     * Получение параметра.
     * @param string $key Индекс параметра.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function getParam($key)
    {
    return $this->$key;
    }
}
?>