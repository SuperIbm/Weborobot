<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Models;

use Illuminate\Support\Manager;


/**
 * Класс системы ведения статистики.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SeoManager extends Manager
{
	/**
	 * @see \Illuminate\Support\Manager::getDefaultDriver
	 */
	public function getDefaultDriver()
	{
	return $this->app['config']['seo.driver'];
	}
}
?>