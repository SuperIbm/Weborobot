<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Models;

use Illuminate\Support\Manager;


/**
 * Класс драйвер фильтрации изображений.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageFilterManager extends Manager
{
	/**
	 * @see \Illuminate\Support\Manager::getDefaultDriver
	 */
	public function getDefaultDriver()
	{
	return $this->app['config']['image.filter'];
	}
}
?>