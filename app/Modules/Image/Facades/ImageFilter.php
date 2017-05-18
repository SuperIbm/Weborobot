<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад класса фильтрации изображений.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageFilter extends Facade
{
	/**
	 * Получить зарегистрированное имя компонента.
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
	return 'image.filter';
	}
}
?>