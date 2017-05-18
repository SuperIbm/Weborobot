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
 * Класс фильтрования изображения для нанесения вотермарка.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageFilterWatermark extends ImageFilter
{
	/**
	 * Метод, который служит для проектирования своего фильтра.
	 * @param string $path Путь к изображению для фильтрования.
	 * @param array $params Параметры для фильтрования.
	 * Принимает значение:
	 * <pre>
	 * array
	 * (
	 * "path" => null, // Путь к изображению водяного знака
	 * "left" => null, // Отступ с левой стороны
	 * "right" => null, // Отступ с правой стороны
	 * "top" => null, // Отступ с верхней стороны
	 * "bottom" => null, // Отступ с нижней стороны
	 * );
	 * </pre>
	 * @return string Возвращает путь на измененное изображение.
	 * @since 1.0
	 */
	public function filter($path, array $params = array())
	{
		if(isset($params["path"]) && file_exists($params["path"]))
		{
		$image = getImageSize($path);
		$width = $image[0];
		$height = $image[1];
		$format = $image[2];
		$imgResource = Image::getResourceByFormat($format, $path);

		$watermarkInfo = getImageSize($params["path"]);

		$watermark = Image::getResourceByFormat($watermarkInfo[2], $params["path"]);
		
		imagealphablending($watermark, true);
		imagealphablending($imgResource, true);
		
			if(isset($params["left"])) $left = $params["left"];
			else if(isset($params["right"])) $left = $width - $watermarkInfo[0] - $params["right"];
			else $left = 0;
			
			if(isset($params["top"])) $top = $params["top"];
			else if(isset($params["bottom"])) $top = $height - $watermarkInfo[1] - $params["bottom"];
			else $top = 0;
			
		imagecopy($imgResource, $watermark, $left, $top, 0, 0, $watermarkInfo[0], $watermarkInfo[1]);

		$byte = Image::getByteByFormat($format, $imgResource);
		$tmpfname = Image::tmp($format);

		File::put($tmpfname, $byte);

		return $tmpfname;
		}
	
	return $path;
	}
}
?>