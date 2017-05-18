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
 * Класс фильтрования изображения для перевода его в фиксированный заданный размер с обрезкой по краям.
 * Этот класс переводит изображение в фиксированный заданный размер, невзирая на первоначальный размер изображения, при этом изображение обрежется по краям.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageFilterChopedSize extends ImageFilter
{
	/**
	 * Метод, который служит для проектирования своего фильтра.
	 * @param string $path Путь к изображению для фильтрования.
	 * @param array $params Параметры для фильтрования.
	 * Принимает значение:
	 * <pre>
	 * array
	 * (
	 * "width" => 200, // Новая ширина
	 * "height" => 200 // Новая высота
	 * );
	 * </pre>
	 * @return string Возвращает путь на измененное изображение.
	 * @since 1.0
	 */
	public function filter($path, array $params = array())
	{
	$image = getImageSize($path);
	$width = $image[0];
	$height = $image[1];
	$format = $image[2];

	$imgResource = Image::getResourceByFormat($format, $path);

	$params["width"] = !isset($params["width"]) ? 200 : $params["width"];
	$params["height"] = !isset($params["height"]) ? 200 : $params["height"];

		if($params["width"] <= $params["height"])
		{
		$ratio = $params["width"] * 100 / $width;

		$widthNewNeed = $params["width"];
		$heightNewNeed = round(($height * $ratio) / 100);
		}
		else
		{
		$ratio = $params["height"] * 100 / $height;

		$widthNewNeed = round(($width * $ratio) / 100);
		$heightNewNeed = $params["height"];
		}

	$des_img = Image::getResourceTransperentColor($widthNewNeed, $heightNewNeed, $format);
	imagecopyresampled($des_img, $imgResource, 0, 0, 0, 0, $widthNewNeed, $heightNewNeed, $width, $height);

	$refForWhiteBck = imagecreatetruecolor($params["width"], $params["height"]);

	imagealphablending($refForWhiteBck, false);
	imagesavealpha($refForWhiteBck, true);

	$transparent = imagecolorallocatealpha($refForWhiteBck, 255, 255, 255, 127);
	imagefilledrectangle($refForWhiteBck, 0, 0, $params["width"], $params["height"], $transparent);

		if($widthNewNeed < $params["width"]) $x = ($params["width"] - $widthNewNeed) / 2;
		else $x = 0;

		if($heightNewNeed < $params["height"]) $y = ($params["height"] - $heightNewNeed) / 2;
		else $y = 0;

	imagecopy($refForWhiteBck, $des_img, $x, $y, 0, 0, $widthNewNeed, $heightNewNeed);

	$byte = Image::getByteByFormat($format, $refForWhiteBck);
	$tmpfname = Image::tmp($format);

	File::put($tmpfname, $byte);

	return $tmpfname;
	}
}
?>