<?php
/**
 * Модуль Временных изображений.
 * Этот модуль содержит все классы для работы с временными изображениями.
 * @package App.Modules.ImageTmp
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ImageTmp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад класса временных изображений.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageTmp extends Facade
{
	/**
	 * Получить зарегистрированное имя компонента.
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
	return 'imageTmp';
	}
}
?>