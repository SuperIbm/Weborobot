<?php
/**
 * Логирование.
 * Пакет содержит классы драйверов для использование различных хранилищь для логирования.
 * @package App.Models.Logs
 * @since 1.0
 * @version 1.0
 */
namespace App\Models\Logs;

use Illuminate\Support\Manager;


/**
 * Класс системы логирования для записи.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogWriterManager extends Manager
{
	/**
	 * @see \Illuminate\Support\Manager::getDefaultDriver
	 */
	public function getDefaultDriver()
	{
	return $this->app['config']['app.log_driver'];
	}
}
?>