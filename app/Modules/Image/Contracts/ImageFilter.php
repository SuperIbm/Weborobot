<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Contracts;

use App\Models\Error;


/**
 * Абстрактный класс фильтрования изображения.
 * Абстрактный класс позволяющий создать свой фильтр для изображения.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class ImageFilter
{
use Error;
	
	
	/**
	 * Абстрактный метод, который служит для проектирования своего фильтра.
	 * @param string $path Путь к изображению для фильтрования.
	 * @param array $params Параметры для фильтрования.
	 * @return string Возвращает путь на измененное изображение.
	 * @since 1.0
	 */
	abstract public function filter($path, array $params = array());
}
?>