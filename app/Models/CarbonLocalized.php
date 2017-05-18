<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */
namespace App\Models;

use Laravelrus\LocalizedCarbon\LocalizedCarbon;

/**
 * Класс работы с датами с поддержкой корректно руссификации.
 * Переводит русифицированный текст с кодировки windows-1251 на utf-8.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CarbonLocalized extends LocalizedCarbon
{
	/**
	 * Форматирование даты с учетом локализации и с поддержкой UTF-8 кодировки.
	 * @param string $format Формат кодирования.
	 * @return string Отформатированная дата по заданому формату.
	 * @since 1.0
	 * @version 1.0
	 */
	public function formatLocalized($format = self::COOKIE)
	{
	$result = parent::formatLocalized($format);

		if(mb_detect_encoding($result) == "UTF-8") return $result;
		else return iconv(mb_detect_encoding($result), 'utf-8', $result);
	}
}
?>