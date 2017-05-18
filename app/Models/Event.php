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
 * Трейт позволяющий добавлять и запускать события внутри модели.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait Event
{
/**
 * Объект интерфейса определяющий методы для добавления, удаления и оповещения наблюдателей.
 * @var \App\Models\Observable
 * @version 1.0
 * @since 1.0
 */
private $_Observable;

	/**
	 * Инициализация объекта интерфейса определяющего методы для добавления, удаления и оповещения наблюдателей.
	 * @return object Возвращает текущий объект.
	 * @since 1.0
	 * @version 1.0
	 */
	private function _init()
	{
		if(!$this->_Observable) $this->_Observable = new Observable();

	return $this;
	}


	/**
	 * Добавление событий.
	 * @param string $action Название события. Если $function пуст, то реализация события происходит через одноименный метод.
	 * @param callable $function Функция, которая должна быть вызвана для этого события.
	 * @return object Возвращает текущий объект.
	 * @since 1.0
	 * @version 1.0
	 */
	public function addEvent($action, $function = null)
	{
	$this->_init();
	$this->_Observable->add($this, $action, $function);
	return $this;
	}


	/**
	 * Удаление события.
	 * @param string $action Название события.
	 * @return object Возвращает текущий объект.
	 * @since 1.0
	 * @version 1.0
	 */
	public function deleteEvent($action)
	{
	$this->_init();
	$this->_Observable->delete($action);
	return $this;
	}


	/**
	 * Проверить если такое событие.
	 * @param string $action Название события.
	 * @return bool Вернет true если событие для наблюдателя существует.
	 * @since 1.0
	 * @version 1.0
	 */
	public function hasEvent($action)
	{
	$this->_init();
	return $this->_Observable->has($action);
	}

	/**
	 * Запуск события и возращения всех значений.
	 * @param string $action Название события.
	 * @param array $params Параметры события, которые передаются в его реализацию.
	 * @return mixed Вернет все возращенные значения реализаций.
	 * @since 1.0
	 * @version 1.0
	 */
	public function fireEvent($action, $params = Array())
	{
	$this->_init();
	return $this->_Observable->fire($action, $params);
	}


	/**
	 * Запуск события и возращения только первого значения.
	 * @param string $action Название события.
	 * @param array $params Параметры события, которые передаются в его реализацию.
	 * @return mixed Вернет первое возращенное значения реализаций.
	 * @since 1.0
	 * @version 1.0
	 */
	public function firstEvent($action, $params = Array())
	{
	$this->_init();
	return $this->_Observable->first($action, $params);
	}


	/**
	 * Запуск события и их исполнение до первого возращенного false.
	 * @param string $action Название события.
	 * @param array $params Параметры события, которые передаются в его реализацию.
	 * @return mixed Вернет первое возращенное значения реализаций.
	 * @since 1.0
	 * @version 1.0
	 */
	public function untilEvent($action, $params = Array())
	{
	$this->_init();
	return $this->_Observable->until($action, $params);
	}
}
?>