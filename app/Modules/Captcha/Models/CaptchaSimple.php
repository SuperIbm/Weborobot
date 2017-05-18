<?php
/**
 * Модуль Captcha .
 * Этот модуль содержит все классы для работы с Captcha.
 * @package App.Modules.Captcha
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Captcha\Models;

use App\Modules\Captcha\Contracts\Captcha;


/**
 * Классы драйвер для проектирования каптчи.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CaptchaSimple extends Captcha
{
	/**
	 * Метод получения каптчи.
	 * @param array $params Параметры для проектирования каптчи:
	 * <ul>
	 * 	<li>pathToTtf - путь к файлу со шрифтом.</li>
	 * 	<li>sizeText - размер текст.</li>
	 * </ul>
	 * @return string Возвращает байт код изображения.
	 * @see \App\Modules\Captcha\Contracts\Captcha::get
	 * @since 1.0
	 * @version 1.0
	 */
	public function get($params = null)
	{
	$sizeText = isset($params["sizeText"]) ? $params["sizeText"] : 24;

		if(isset($params["pathToTtf"]))
		{
		$im = imagecreatetruecolor(120, 40);
		$bg = imagecolorallocate($im, 240, 240, 240);
		imagefilledrectangle($im, 0, 40, 120, 0, $bg);

			for ($i = 0; $i <= 450; $i++)
			{
			$color = imagecolorallocate($im, rand(0, 210), rand(0, 210), rand(0, 210));
			imagesetpixel($im, rand(2, 120), rand(2, 40), $color);
			}

		$char = $this->getText();

			for ($i = 0; $i < strlen($char); $i++)
			{
			$color = imagecolorallocate($im, rand(0, 160), rand(0, 160), rand(0, 160));
			$x = 20 + $i * $sizeText;
			$y = rand(25, 35);
			imageTTFText($im, $sizeText, 0, $x, $y, $color, $params["pathToTtf"], $char[$i]);
			}

		ob_start();
		imagejpeg($im);
		$byte = ob_get_contents();
		ob_end_clean();

		return $byte;
		}

	return false;
	}
}