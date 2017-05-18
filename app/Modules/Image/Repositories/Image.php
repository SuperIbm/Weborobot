<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Repositories;

use File;
use Util;
use App\Models\Repositary;

/**
 * Абстрактный класс построения репозитария.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Image extends Repositary
{
/**
 * Полученные раннее изображения.
 * Будем хранить данные полученных ранее изображений, чтобы снизить нагрузку на систему.
 * @var array
 * @version 1.0
 * @since 1.0
 */
private static $_images = Array();

	/**
	 * Получение изображения по ее ID из базы ранее полученных изображений.
	 * @param int $id ID изображения.
	 * @return array|bool Массив данных страницы.
	 * @since 1.0
	 * @version 1.0
	 */
	protected static function _getById($id)
	{
		if(isset(self::$_images[$id])) return self::$_images[$id];
		else return false;
	}


	/**
	 * Установка данных изображения по ее ID в базу ранее полученных изображений.
	 * @param int $id ID изображения.
	 * @param array $image Данные изображения.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	protected static function _setById($id, $image)
	{
	self::$_images[$id] = $image;
	}


	/**
	 * Получение всех записей.
	 * @return array Массив данных.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function all();


	/**
	 * Создание.
	 * @param string $path Путь к файлу.
	 * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function create($path);


	/**
	 * Обновление.
	 * @param int $id Id записи для обновления.
	 * @param string $path Путь к файлу.
	 * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function update($id, $path);


	/**
	 * Обновление байт кода картинки.
	 * @param int $id Id записи для обновления.
	 * @param string $byte Байт код картинки.
	 * @return bool Вернет булево значение успешности операции.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function updateByte($id, $byte);


	/**
	 * Удаление.
	 * @param int|array $id Id записи для удаления.
	 * @return bool Вернет булево значение успешности операции.
	 * @since 1.0
	 * @version 1.0
	 */
	abstract public function destroy($id);


	/**
	 * Резка изображения по заданной ширине и высоте.
	 * @param string $path Путь к изображению.
	 * @param int $widthNew Новая ширина изображения.
	 * @param int $heightNew Новая высота изображения.
	 * @return string Возвращает путь к новому изображению.
	 * @since 1.0
	 * @version 1.0
	 */
	public function cut($path, $widthNew = null, $heightNew = null)
	{
	$pro = getImageSize($path);
	$widthOld = $pro[0];
	$heightOld = $pro[1];
	$format = $pro[2];

		if($this->isRastGtByFile($path))
		{
		$img = $this->getResourceByFormat($format, $path);

			if(!$heightNew && !$widthNew)
			{
			$imgDest = $this->getResourceTransperentColor($widthOld, $widthOld, $format);
			imagecopyresampled($imgDest, $img, 0, 0, 0, 0, $widthOld, $widthOld, $widthOld, $heightOld);
			}
			else if($widthOld < $widthNew && $heightOld < $heightNew)
			{
			$imgDest = $this->getResourceTransperentColor($widthOld, $widthOld, $format);
			imagecopyresampled($imgDest, $img, ($widthNew - $widthOld) / 2, ($heightNew - $heightOld) / 2, 0, 0, $widthOld, $heightOld, $widthOld, $heightOld);
			}
			else if($widthNew == $heightNew)
			{
			$imgDest = $this->getResourceTransperentColor($widthNew, $heightNew, $format);

				if($widthOld == $heightOld)
				{
				imagecopyresampled($imgDest, $img, 0, 0, 0, 0, $widthNew, $heightNew, $widthOld, $heightOld);
				}
				else if($widthOld > $heightOld)
				{
				imagecopyresampled($imgDest, $img, 0, 0, round((max($widthOld, $heightOld) - min($widthOld, $heightOld)) / 2), 0, $widthNew, $heightNew, min($widthOld, $heightOld), min($widthOld, $heightOld));
				}
				else if($widthOld < $heightOld)
				{
				imagecopyresampled($imgDest, $img, 0, 0, 0, round((max($widthOld, $heightOld) - min($widthOld, $heightOld)) / 2), $widthNew, $heightNew, min($widthOld, $heightOld), min($widthOld, $heightOld));
				}
			}
			else if($widthNew)
			{
			$ratio = ($widthNew * 100) / $widthOld;
			$heightNew = round(($heightOld * $ratio) / 100);
			$imgDest = $this->getResourceTransperentColor($widthNew, $heightNew, $format);

			imagecopyresampled($imgDest, $img, 0, 0, 0, 0, $widthNew, $heightNew, $widthOld, $heightOld);
			}
			else
			{
			$ratio = ($heightNew * 100) / $heightOld;
			$widthNew = round(($widthOld * $ratio) / 100);
			$imgDest = $this->getResourceTransperentColor($widthNew, $heightNew, $format);

			imagecopyresampled($imgDest, $img, 0, 0, 0, 0, $widthNew, $heightNew, $widthOld, $heightOld);
			}

		$byte = $this->getByteByFormat($pro[2], $imgDest);
		$tmpfname = $this->tmp($pro[2]);

		File::put($tmpfname, $byte);
		return $tmpfname;
		}

	return false;
	}


	/**
	 * Проверка размера изображения.
	 * @param int $widthCurrent Текущая ширина.
	 * @param int $heightCurrent Текущая высота.
	 * @param int $widthMin Минимальная ширина.
	 * @param int $widthMax Максимальная ширина.
	 * @param int $heightMin Минимальная высота.
	 * @param int $heightMax Максимальная высота.
	 * @return bool Возвращает true если размер соответствует заданным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isSize($widthCurrent, $heightCurrent, $widthMin = null, $widthMax = null, $heightMin = null, $heightMax = null)
	{
		if($widthMin != null && $widthMin > $widthCurrent) return false;
		if($widthMax != null && $widthMax < $widthCurrent) return false;
		if($heightMin != null && $heightMin > $heightCurrent) return false;
		if($heightMax != null && $heightMax < $heightCurrent) return false;

	return true;
	}


	/**
	 * Проверка размера изображения указывая файл.
	 * @param string $path Путь к изображению.
	 * @param int $widthMin Минимальная ширина.
	 * @param int $widthMax Максимальная ширина.
	 * @param int $heightMin Минимальная высота.
	 * @param int $heightMax Максимальная высота.
	 * @return bool Возвращает true если размер соответствует заданным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isSizeByFile($path, $widthMin = null, $widthMax = null, $heightMin = null, $heightMax = null)
	{
	$pro = getImageSize($path);
	return $this->isSize($pro[0], $pro[1], $widthMin, $widthMax, $heightMin, $heightMax);
	}


	/**
	 * Проверяет вес изображения в байтах.
	 * @param int $weight Вес изображения в байтах.
	 * @param int $weightMin Минимальный вес в байтах.
	 * @param int $weightMax Максимальный вес в байтах.
	 * @return bool Возвращает true если вес соответствует заданным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isWeight($weight, $weightMin = null, $weightMax = null)
	{
		if($weightMin != null && $weightMin > $weight) return false;
		if($weightMax != null && $weightMax < $weight) return false;

	return true;
	}


	/**
	 * Проверка веса изображения указывая файл.
	 * @param string $path Путь к изображению.
	 * @param int $weightMin Минимальный вес в байтах.
	 * @param int $weightMax Максимальный вес в байтах.
	 * @return bool Возвращает true если вес соответствует заданным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isWeightByFile($path, $weightMin = null, $weightMax = null)
	{
	$weight = filesize($path);
	return $this->isWeight($weight, $weightMin, $weightMax);
	}


	/**
	 * Создание копии изображения.
	 * Коппия создается во временной папке с псевдослучайным названием.
	 * @param string $path Путь к изображению из которого нужно сделать копию.
	 * @return string|bool Возвращает путь к копии.
	 * @since 1.0
	 * @version 1.0
	 */
	public function copy($path)
	{
	$pro = @getImageSize($path);

	    if($pro)
        {
        $tmpfname = $this->tmp($pro[2]);
        File::copy($path, $tmpfname);

        return $tmpfname;
        }
        else return false;
	}


	/**
	 * Производит конвертирования изображения из одного формата в другой.
	 * @param string $path Путь к изображению.
	 * @param string $formatTo Новый формат для изображения.
	 * @return string Возвращает путь к новому изображению.
	 * @since 1.0
	 * @version 1.0
	 */
	public function convertTo($path, $formatTo)
	{
		if($this->isRastGtByFile($path) == true)
		{
		$tmpfname = $this->tmp($formatTo);
		File::put($tmpfname, File::get($path));
		return $tmpfname;
		}
		else return false;
	}


	/**
	 * Производит поворот изображения согласно указанному углу.
	 * @param string $path Путь к изображению.
	 * @param int $angle Угол поворота.
	 * @return string Возвращает путь к повернутому изображению.
	 * @since 1.0
	 * @version 1.0
	 */
	public function rotate($path, $angle = 90)
	{
		if($this->isRastGtByFile($path) == true)
		{
		$pro = @getImageSize($path);

            if($pro)
            {
            $format = $this->getFormatText($pro[2]);

            $imgResource = $this->getResourceByFormat($pro[2], $path);
            $imgResource = imagerotate($imgResource, $angle, 0);

            $byte = $this->getByteByFormat($pro[2], $imgResource);
            $tmpfname = $this->tmp($format);

            File::put($tmpfname, $byte);

            return $tmpfname;
            }
            else return false;
		}
		else return false;
	}


	/**
	 * Проверяет растровое ли изображение, с которым может работать библиотека GD2.
	 * @param string $path Путь к изображению.
	 * @return bool Возвращает true если изображение растровое.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isRastGtByFile($path)
	{
	$pro = @getImageSize($path);

		if($pro)
		{
		$format = $pro[2];

			if($format >= 1 && $format <= 3) return true;
			else return false;
		}
		else return false;
	}


	/**
	 * Проверка векторное ли изображение.
	 * @param string $path Путь к изображению.
	 * @return bool Возвращает true если изображение векторное.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isVektrByFile($path)
	{
	$pro = @getImageSize($path);

	    if($pro)
        {
            $format = $pro[2];

            if($format == 4 || $format == 13) return true;
            else return false;
        }
        else return false;
	}


	/**
	 * Проверка является ли файл изображением.
	 * @param string $path Путь к изображению.
	 * @return bool Возвращает true если файл изображение.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isImageByFile($path)
	{
		if($this->isRastGtByFile($path) == true || $this->isVektrByFile($path) == true) return true;
		else return false;
	}


	/**
	 * Проверка является ли расширение изображением.
	 * @param string $extension Расширение без точки.
	 * @return bool Возвращает true если расширение относиться к изображению.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isImageByExtension($extension)
	{
		if($this->isRastGtByExtension($extension) || $this->isVektrByExtension($extension)) return true;
		else return false;
	}


	/**
	 * Проверка является ли расширение растровым.
	 * @param string $extension Расширение без точки.
	 * @return bool Возвращает true если расширение растровое.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isRastGtByExtension($extension)
	{
		if(in_array($extension, array("jpg", "jpeg", "gif", "png"))) return true;
		else return false;
	}


	/**
	 * Проверка является ли расширение векторным.
	 * @param string $extension Расширение без точки.
	 * @return bool Возвращает true если расширение векторное.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isVektrByExtension($extension)
	{
		if(in_array($extension, Array("swf", "flw"))) return true;
		else return false;
	}


	/**
	 * Переводит  нумерованный формат  в текстовый формат.
	 * @param int $format Нумерованный формат.
	 * @return string Текстовый формат.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getFormatText($format)
	{
		switch($format)
		{
		case 1: return "gif";
		case 2: return "jpg";
		case 3: return "png";
		case 4: return "swf";
		case 5: return "psd";
		case 6: return "bmp";
		case 7: return "tiff";
		case 8: return "tiff";
		case 9: return "jpc";
		case 10: return "jp2";
		case 11: return "jpx";
		case 13: return "swf";
		}

	return false;
	}


	/**
	 * Переводит текстовый формат в нумерованный формат.
	 * @param string $format Текстовый формат.
	 * @return int Нумерованный формат.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getFormatNumber($format)
	{
		switch(Util::toLower($format))
		{
		case "gif": return 1;
		case "jpg": return 2;
		case "png": return 3;
		case "swf": return 4;
		case "psd": return 5;
		case "bmp": return 6;
		case "tiff": return 7;
		case "jpc": return 9;
		case "jp2": return 10;
		case "jpx": return 11;
		}

	return false;
	}


	/**
	 * Получение идентификатора изображения.
	 * @param mixed $format Формат изображения в нумерованном виде или текстовом.
	 * @param string $path Путь к изображению.
	 * @return resource|bool Возвращает идентификатор изображения, полученного из данного файла.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getResourceByFormat($format, $path)
	{
		if($format == 3 || $format == "png") return imageCreateFromPng($path);
		else if($format == 2 || $format == "jpg") return imageCreateFromJpeg($path);
		else if($format == 1 || $format == "gif") return imageCreateFromGif($path);

	return false;
	}


	/**
	 * Получает байт код изображения.
	 * @param mixed $format Формат изображения в нумерованном виде или текстовом.
	 * @param resource $imgResource Идентификатор изображения.
	 * @param int $quality Качество изображения. Работает только для формата jpg.
	 * @return string Байт код изображения.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getByteByFormat($format, $imgResource, $quality = 95)
	{
		if($format == 3 || $format == "png" || $format == 2 || $format == "jpg" || $format == 1 || $format == "gif")
		{
		ob_start();

			if($format == 3 || $format == "png") imagePng($imgResource);
			else if($format == 2 || $format == "jpg") imageJpeg($imgResource, null, $quality);
			else if($format == 1 || $format == "gif") imageGif($imgResource);

		$byte = ob_get_contents();
		ob_end_clean();
		return $byte;
		}

	return false;
	}


	/**
	 * Получение идентификатора прозрачного изображения с заданными размерами и форматом.
	 * @param int $widthNew Новая ширина изображения.
	 * @param int $heightNew Новая высота изображения.
	 * @param mixed $format Формат изображения в нумерованном виде или текстовом.
	 * @return resource Возвращает идентификатор изображения.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getResourceTransperentColor($widthNew, $heightNew, $format)
	{
		if($format == 1 || $format == "gif")
		{
		$imgDest = imagecreate($widthNew, $heightNew);
		$transparent = imagecolorallocate($imgDest, 255, 255, 255);
		imagecolortransparent($imgDest, $transparent);
		}
		else
		{
		$imgDest = imagecreatetruecolor($widthNew, $heightNew);

		imagealphablending($imgDest, false);
		imagesavealpha($imgDest, true);

		$transparent = imagecolorallocatealpha($imgDest, 255, 255, 255, 127);
		}

	imagefilledrectangle($imgDest, 0, 0, $widthNew, $heightNew, $transparent);
	return $imgDest;
	}



	/**
	 * Получение пути к файлу для временного изображения.
	 * @param mixed $format Формат изображения в нумерованном виде или текстовом.
	 * @return string Путь к временному изображению.
	 * @since 1.0
	 * @version 1.0
	 */
	public function tmp($format)
	{
	return storage_path('app/tmp/img_'.time().mt_rand(1, 100000).'.'.$this->getFormatText($format));
	}
}