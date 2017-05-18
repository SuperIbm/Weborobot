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
 * Класс фильтрования изображения для перевода его в фиксированный заданный размер без обрезки по краям.
 * Этот класс переводит изображение в фиксированный заданный размер, невзирая на первоначальный размер изображения, но при этом он не будет обрезать по краям, а в случаи чего сделает края прозрачными.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageFilterFixedSize extends ImageFilter
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
	
		if($width <= $height)
		{
		$ratio = ($params["height"] * 100) / $height;
		$heightNewNeed = $params["height"];
		$widthNewNeed = round(($width * $ratio) / 100);
		}
		else
		{
		$ratio = ($params["width"] * 100) / $width;
		$widthNewNeed = $params["width"];
		$heightNewNeed = round(($height * $ratio) / 100);
		}

	$des_img = Image::getResourceTransperentColor($widthNewNeed, $heightNewNeed, $format);
	imagecopyresampled($des_img, $imgResource, 0, 0, 0, 0, $widthNewNeed, $heightNewNeed, $width, $height);
	
	$refForWhiteBck = imagecreatetruecolor($params["width"], $params["height"]);

	imagealphablending($refForWhiteBck, false);
	imagesavealpha($refForWhiteBck, true);

	$transparent = imagecolorallocatealpha($refForWhiteBck, 255, 255, 255, 127);
	imagefilledrectangle($refForWhiteBck, 0, 0, $params["width"], $params["height"], $transparent);

	imagecopy($refForWhiteBck, $des_img, ($params["width"] - $widthNewNeed) / 2, ($params["height"] - $heightNewNeed) / 2, 0, 0, $widthNewNeed, $heightNewNeed);

	$byte = Image::getByteByFormat($format, $refForWhiteBck);
	$tmpfname = Image::tmp($format);

	File::put($tmpfname, $byte);

	return $tmpfname;
	}
}
?>