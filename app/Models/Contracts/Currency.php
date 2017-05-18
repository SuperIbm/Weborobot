<?php
/**
 * Контракты.
 * Этот пакет содержит контракты ядра системы.
 * @package App.Models.Contracts
 * @since 1.0
 * @version 1.0
 */
namespace App\Models\Contracts;

use App\Models\CarbonLocalized;
use App\Models\Error;

/**
 * Абстрактный класс для проектирования собственной системы котировок.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Currency
{
use Error;

	/**
	 * Получение валюты по коду валюты.
	 * @param \App\Models\CarbonLocalized $Carbon Дата на которую нужно получить котировки.
	 * @param string $charCode Код валюты для получения котировки. Если не указать, то вернет все валюты.
	 * @return array Массив данных запрашиваемой валюты.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function get(CarbonLocalized $Carbon, $charCode);
}