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
 * Параметры декоратора.
 * @var array
 * @version 1.0
 * @since 1.0
 */
private $_params = [];

	/**
	 * Этот абстрактный метод предназначен для проектирования собственных действий в декораторе.
	 * @param array $params Параметры декоратора.
	 * @param \App\Models\Decorator $ParentDecorator Родительский декоратор.
	 * @return bool Должен вернуть true если действие выполнено успешно.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract protected function _action($params, Decorator $ParentDecorator = null);
	
	
	/**
	 * Абстрактный метод получения индекса.
	 * Этот индекс используется в массиве данных для сохранения тех данных, которые были созданы этим декоратором.
	 * @return string Название индекса.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function getIndex();

	
	/**
	 * Конструктор.
	 * Назначенные события:
	 *
	 * <strong>beforeAction</strong> - Вызвать, перед тем как выполнит действие. Передает значения:
	 * <ul>
	 * 	<li>Объект декоратора</li>
	 * </ul>
	 * Если вернет булево значение false, то остановит дальнейшее действие.
	 *
	 *
	 * <strong>afterAction</strong> - Вызвать после того как выполнено действие. Передает значения:
	 * <ul>
	 * 	<li>Объект декоратора</li>
	 * 	<li>Статус исполнения действия, где true это выполнено без ошибок</li>
	 * </ul>
	 * Если вернет булево значение false, то остановит дальнейшее действие.
	 *
	 * @param array|string $decorators Массив декораторов, которые нужно выполнить. Или один объект декоратор \App\Models\Decorator.
	 * @param array $params Параметры для декоратора.
	 * @since 1.0
	 * @version 1.0
	 */
	public function __construct($decorators = null, $params = null)
	{
		if(!is_array($decorators)) $decorators = [$decorators];

		if($decorators)
        {
            for($i = 0; $i < count($decorators); $i++)
            {
                if(isset($decorators[$i])) $this->addDecorator($decorators[$i]);
            }
        }
		
		if($params) $this->setParams($params);

	$this->addEvent("beforeAction");
	$this->addEvent("afterAction");
	}
	
	
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
	 * Установка параметров.
	 * @param array $params Параметры компонента для его работы.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function setParams($params)
	{
		foreach($params AS $k => $v)
		{
			if(isset($v) == false) unset($params[$k]);
		}
	
	$this->_params = $params;
	return $this;
	}
	
	
	/**
	 * Добавление параметра.
	 * @param string $index Индекс параметра.
	 * @param mixed $param Параметры компонента для его работы.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function addParam($index, $param)
	{
	$this->_params[$index] = $param;
	return $this;
	}


	/**
	 * Удаление параметра.
	 * @param string $index Индекс параметра.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function deleteParam($index)
	{
		if(isset($this->_params[$index])) unset($this->_params[$index]);

	return $this;
	}
	
	
	/**
	 * Получение параметров.
	 * @param string $index Название параметра. Если не указать вернет все параметры.
	 * @param mixed $default Если параметр не задан, то вернуть это значение по умолчанию.
	 * @return mixed Параметр для компонента.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getParams($index = null, $default = null)
	{
		if($index)
		{
			if(isset($this->_params[$index])) return $this->_params[$index];
			else
			{
			$ParentDecorator = $this->getParentDecorator();
			
				if($ParentDecorator) $value = $ParentDecorator->getParams($index, null);
				else $value = null;
				
				if($value) return $value;
				else if(isset($default))
                {
                    if(@function_exists($default)) return call_user_func_array($default, []);
                    else return $default;
                }
				else return null;
			}
		}
		else return $this->_params;
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
	$status = $this->untilEvent("beforeAction");
	
		if($status == true)
		{
		$status = $this->_action($this->getParams(), $this->getParentDecorator());
		
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
}
?>