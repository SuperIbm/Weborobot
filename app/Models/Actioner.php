<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */
namespace App\Models;

use Cookie;
use Path;
use Session;


/**
 * Класс запоминания действий пользователя.
 * Класс, который позволяет вести учет действий пользователя, если требуется контролировать, сколько раз он имеет право его выполнить
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Actioner
{
	/**
	 * Проверка статуса действий.
	 * Позволяет определить, сколько раз выполнялось действие и может ли действие снова быть осуществлено.
	 * @param string $index Индекс действия.
	 * @param int $maxCount Сколько раз это действий может быть исполнено.
	 * @param int $minutes Через сколько минут это действие будет доступно.
	 * @return bool Если вернет true, то действие может быть выполнено еще раз. Если false, то максимальный порог его выполнения достигнут.
	 * @since 1.0
	 * @version 1.0
	 */
	public function status($index, $maxCount, $minutes = 60)
	{
	$value = $this->_get($index);

		if($value)
		{
		$timeCurrent = time();
		$timeEnd = ($minutes * 60) + $value["time"];

			if($timeCurrent >= $timeEnd)
			{
			$this->delete($index);
			return true;
			}
			else
			{
				if($value["count"] <= $maxCount) return true;
				else return false;
			}
		}
		else return true;
	}
	
	
	/**
	 * Добавление действия.
	 * @param string $index Индекс действия.
	 * @param int $to Добавить к количеству выполненных действий.
	 * @param int $minutes Общее время жизни этой записи в минутах.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function add($index, $to = 1, $minutes = 60 * 24 * 31)
	{
		$value = $this->_get($index,
			[
			"count" => 0,
			"minutes" => $minutes,
			"time" => time(),
			]
		);

	$value["count"] += $to;
	$this->_set($index, $value["count"], $value["minutes"]);

	return $this;
	}


	/**
	 * Очистка истории действий.
	 * Позволяет удалить всю историю об этом действии, заодно обнулив весь результат.
	 * @param string $index Индекс действия.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	public function delete($index)
	{
	Session::forget($this->_getKey($index));
	Cookie::forget($this->_getKey($index));
	return $this;
	}


	/**
	 * Получение действия по индексу.
	 * @param string $index Индекс действия.
	 * @param array $default Значение по умолчанию, если значение отсуствует.
	 * @return array Возвращает массив значений действия.
	 * @since 1.0
	 * @version 1.0
	 */
	protected function _get($index, $default = null)
	{
	$key = $this->_getKey($index);
	$value = Cookie::get($key);

		if(!$value)
		{
		$value = Session::get($key);

			if($value) return $value;
			else if($default) return $default;
			else return null;
		}
		else
		{
		$value = explode("~", $value);

			return
			[
			"count" => $value[0],
			"minutes" => $value[1],
			"time" => $value[2],
			];
		}
	}


	/**
	 * Запись действия.
	 * @param string $index Индекс действия.
	 * @param int $count Попыток действий.
	 * @param int $minutes Количество минут через которые действией можно будет повторить.
	 * @param int $time Время в Unix формате, когда действие было произведено.
	 * @return $this
	 * @since 1.0
	 * @version 1.0
	 */
	protected function _set($index, $count, $minutes, $time = null)
	{
	$time = isset($time) ? $time : time();

		Session::put($this->_getKey($index),
			[
			"count" => $count,
			"minutes" => $minutes,
			"time" => $time
			]
		);

	Cookie::make($this->_getKey($index), $count."~".$minutes."~".$time, $minutes);
	return $this;
	}


	/**
	 * Получение ключа по индексу.
	 * @param string $index Индекс действия.
	 * @return string Ключ.
	 * @since 1.0
	 * @version 1.0
	 */
	protected function _getKey($index)
	{
	return md5("action.".Path::getUserIp().".".$index);
	}
}
?>