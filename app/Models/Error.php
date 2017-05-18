<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */
namespace App\Models;

use Util;

/**
 * Трейт ошибок.
 * @version 1.0
 * @since 1.0
 * @copyright 2008-2013 Сайтография.
 * @author Инчагов Тимофей Александрович.
 */
trait Error
{
/**
 * Массив ошибок.
 * @var array
 * @version 1.0
 * @since 1.0
 */
private $_errors = Array();
	
	
	/**
	 * Очистить ошибку.
	 * @return object Возвращает текущий объект.
	 * @since 1.0
	 * @version 1.0
	 */
	public function cleanError()
	{
	$this->_errors = Array();
	return $this;
	}
	
	
	/**
	 * Проверка наличия ошибки.
	 * @return bool Вернет true если есть ошибка.
	 * @since 1.0
	 * @version 1.0
	 */
	public function hasError()
	{
		if(count($this->_errors) == 0) return false;
	
	return true;
	}
	
	
	/**
	 * Добавление ошибки.
	 * @param mixed $type Тип ошибки, это может быть краткий ее индификатор, или название. Это так же может быть массив, состоящий из:
	 * <pre>
	 * array
	 * (
	 * "type" => "Тип ошибки",
	 * "message" => "Сообщение об ошибки",
	 * "tag" => "Тэг ошибки, нужен для спец описания"
	 * )
	 * </pre>
	 * @param string $message Сообщение об ошибки.
	 * @param string $tag Тэг ошибки, нужен для спец описания.
	 * @return object Возвращает текущий объект.
	 * @since 1.0
	 * @version 1.0
	 */
	public function addError($type, $message = null, $tag = null)
	{
		if(is_array($type))
		{
			if(Util::isAssoc($type)) $this->_errors[] = $type;
			else $this->_errors = array_merge($this->_errors, $type);
		}
		else
		{
			$this->_errors[] = array
			(
			"type" => $type,
			"message" => $message,
			"tag" => $tag,
			);
		}

	return $this;
	}
	
	
	/**
	 * Получение ошибки по номеру.
	 * @param int $index Номер ошибки.
	 * @return array|bool Массив с описанием ошибки, где:
	 * <ul>
	 * 	<li>type - тип ошибки</li>
	 * 	<li>message - сообщение об ошибки</li>
	 * 	<li>tag - тэг ошибки, нужен для спец описания.</li>
	 * </ul>
	 * @since 1.0
	 * @version 1.0
	 */
	public function getError($index = 0)
	{
		if($this->hasError())
		{
			if(isset($index))
			{
				if(isset($this->_errors[$index])) return $this->_errors[$index];
				else return false;
			}
		}
		return false;
	}


	/**
	 * Получение всех ошибок.
	 * @return array|bool Массив с описанием ошибки, где:
	 * <ul>
	 * 	<li>type - тип ошибки</li>
	 * 	<li>message - сообщение об ошибки</li>
	 * 	<li>tag - тэг ошибки, нужен для спец описания.</li>
	 * </ul>
	 * @since 1.0
	 * @version 1.0
	 */
	public function getErrors()
	{
		if($this->hasError()) return $this->_errors;
		return false;
	}


	/**
	 * Получение полного описания ошибки.
	 * @param int $index Номер ошибки.
	 * @return string Строка с описанием ошибки.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getErrorString($index = 0)
	{
		if($this->hasError())
		{
		$mes = $this->getErrorType($index);

			if($mes)
			{
				if($this->getErrorNumber($index)) $mes .= ", ".$this->getErrorNumber($index);
				if($this->getErrorMessage($index)) $mes .= ": ".$this->getErrorMessage($index);

				return $mes;
			}
			else return false;
		}
		else return false;
	}
	
	
	/**
	 * Получение типа ошибки.
	 * @param int $index Номер ошибки.
	 * @return string Тип ошибки, это может быть краткий ее индификатор. 
	 * @since 1.0
	 * @version 1.0
	 */
	public function getErrorType($index = 0)
	{
		if($this->hasError())
		{
			if(isset($this->_errors[$index]["type"])) return $this->_errors[$index]["type"];
			else return false;
		}
		else return false;
	}
	
	
	/**
	 * Получение сообщения об ошибки.
	 * @param int $index Номер ошибки.
	 * @return string Сообщение об ошибки. 
	 * @since 1.0
	 * @version 1.0
	 */
	public function getErrorMessage($index = 0)
	{
		if($this->hasError())
		{
			if(isset($this->_errors[$index]["message"])) return $this->_errors[$index]["message"];
			else return false;
		}
		else return false;
	}
	
	
	/**
	 * Получение номера ошибки.
	 * @param int $index Номер ошибки.
	 * @return string Номер ошибки. 
	 * @since 1.0
	 * @version 1.0
	 */
	public function getErrorNumber($index = 0)
	{
		if($this->hasError())
		{
			if(isset($this->_errors[$index]["tag"])) return $this->_errors[$index]["tag"];
			else return false;
		}
		else return false;
	}
}
?>