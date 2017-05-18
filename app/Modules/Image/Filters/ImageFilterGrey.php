<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Filters;

use Image;
use App\Modules\Image\Contracts\ImageFilter;
use File;


/**
 * Класс фильтрования изображения для перевода его в серый цвет.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageFilterGrey extends ImageFilter
{
	/**
	 * Метод, который служит для проектирования своего фильтра.
	 * @param string $path Путь к изображению для фильтрования.
	 * @param array $params Параметры для фильтрования.
	 * @return string Возвращает путь на измененное изображение.
	 * @since 1.0
	 */
	public function filter($path, array $params = array())
	{
	$image = getImageSize($path);
	$format = $image[2];
	$imgResource = Image::getResourceByFormat($format, $path);

	imagefilter($imgResource, IMG_FILTER_GRAYSCALE);

	$byte = Image::getByteByFormat($format, $imgResource);
	$tmpfname = Image::tmp($format);

	File::put($tmpfname, $byte);
	
	return $tmpfname;
	}
}
?>