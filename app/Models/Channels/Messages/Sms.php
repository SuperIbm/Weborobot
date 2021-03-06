<?php
/**
 * Сборка сообщений.
 * Этот пакет содержит классы для сборки быстрых сообщений.
 * @package App.Models.Channels
 * @since 1.0
 * @version 1.0
 */
namespace App\Models\Channels\Messages;


/**
 * Класс сборки SMS сообщений для быстрой отправки.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Sms
{
/**
 * Уровень сообщения.
 * @var string
 * @since 1.0
 * @version 1.0
 */
public $level = 'info';

/**
 * Отправитель сообщения.
 * @var string|null
 * @since 1.0
 * @version 1.0
 */
public $sender;

/**
 * Сообщение для отправки.
 * @var string
 * @since 1.0
 * @version 1.0
 */
public $message;

/**
 * Булево значение, определяющее нужно ли транслировать текст.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
public $translit = false;


	/**
	 * Индикатор того, что сообщение было удачно отправлено.
	 * @return $this
	 * @since 1.0
 	 * @version 1.0
	 */
	public function success()
	{
	$this->level = 'success';
	return $this;
	}

	/**
	 * Индикатор того что во время отправки произошла ошибка.
	 * @return $this
	 * @since 1.0
 	 * @version 1.0
	 */
	public function error()
	{
	$this->level = 'error';
	return $this;
	}

	/**
	 * Устанавливаем отправителя сообщения.
	 * @param string $sender Отправитель сообщения.
	 * @return $this
	 * @since 1.0
 	 * @version 1.0
	 */
	public function sender($sender)
	{
	$this->sender = $sender;
	return $this;
	}


	/**
	 * Устанавливаем сообщение на отправку.
	 * @param string $message Сообщение для отправик.
	 * @return $this
	 * @since 1.0
 	 * @version 1.0
	 */
	public function message($message)
	{
	$this->message = $message;
	return $this;
	}


	/**
	 * Определяем нужно ли транслировать текст.
	 * @param bool $translit Булево значение для определения транслитации.
	 * @return $this
	 * @since 1.0
 	 * @version 1.0
	 */
	public function translit($translit)
	{
	$this->translit = $translit;
	return $this;
	}
}