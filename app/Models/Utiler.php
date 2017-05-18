<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */
namespace App\Models;


/**
 * Класс работы с утилитами.
 * Этот класс содержит небольшие методы, которые часто требуются для выполнения тривиальных задач.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Utiler
{	
	/**
	 * Получение массива с уникальными значениями.
	 * @param array $array Массив для отборки.
	 * @return array Массив с уникальными значениями.
	 * @since 1.0
	 * @version 1.0
	 */
	public function arrayUnique($array)
	{
	$array = array_unique($array);
	$newArray = Array();
	$z = 0;
		
		foreach($array AS $k => $v)
		{
		$newArray[$z] = $v;
		$z++;
		}
		
	return $newArray;
	}
	
	
	/**
	 * Конвертирование из одной кодировки в другую.
	 * @param mixed $arString Переменная со строками.
	 * @param string $from Из кодировки.
	 * @param string $to В кодировку.
	 * @return mixed Переменная с переконвертированными строками.
	 * @since 1.0
	 * @version 1.0
	 */
	public function iconv($arString, $from = 'utf-8', $to = 'windows-1251')
	{
		if(is_array($arString))
		{
			foreach($arString AS $k=>$v)
			{
				if(is_array($v) == true) $arString[$k] = $this->iconv($v, $from, $to);
				else
				{
				$v = @iconv($from, $to, $arString[$k]);
				
					if($v != false) $arString[$k] = $v;
				}
			}
		}
		else $arString = @iconv($from, $to, $arString);
		
	return $arString;
	}
	
	
	/**
	 * Перевод JSON в переменную PHP.
	 * @param string $json Строка JSON для перевода.
	 * @param bool $assoc Если true, то переведет в ассоциативный массив.
	 * @return array|null Возвращает переменную.
	 * @since 1.0
	 * @version 1.0
	 */
	public function json2php($json, $assoc = true)
	{
		try
		{
		return json_decode($json, $assoc);
		}
		catch(\Exception $e)
		{
		return null;
		}
	}
	
	
	/**
	 * Перевод переменной в JSON.
	 * @param mixed $value Значение для перевода в JSON.
	 * @return string JSON.
	 * @since 1.0
	 * @version 1.0
	 */
	public function php2json($value)
	{
	return json_encode($value);
	}
	
	
	
	/**
	 * Перевод строки в верхний регистр.
	 * @param string $content Строка.
	 * @param string $encode Кодировка.
	 * @return string Строка в верхнем регистре.
	 * @since 1.0
	 * @version 1.0
	 */
	public function toUpper($content, $encode = "UTF-8")
	{ 
	return mb_strtoupper($content, $encode);
	}


	/**
	 * Перевод строки в верхний регистр.
	 * @param string $content Строка.
	 * @return string Строка в верхнем регистре.
	 * @since 1.0
	 * @version 1.0
	 */
	public function toLower($content)
	{ 
	return mb_strtolower($content, "UTF-8");
	}
	
	
	/**
	 * Переводит первый символ строки в верхний регистр.
	 * @param string $content Строка.
	 * @return string Строка с первым символом в верхнем регистре.
	 * @since 1.0
	 * @version 1.0
	 */
	public function toUcfirst($content)
	{ 
	$enc = "UTF-8";	
	return $this->toUpper(mb_substr($content, 0, 1, $enc), $enc).$this->toLower(mb_substr($content, 1, mb_strlen($content, $enc), $enc));
	}
	
	
	/**
	 * Получение очищенной строки поиска.
	 * @param string $string Строка поиска.
	 * @return string Очищенная строка поиска.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getCorrectSearchStr($string)
	{
	return preg_replace('/[^a-z0-9 \x80-\xFF]/i', "", $string);
	}
	
	
	/**
	 * Очистка строки от всех HTML тэгов.
	 * @param string $string Строка.
	 * @return string Очищенная строка.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getText($string)
	{
	$string = trim($string);
	$string = strip_tags($string);
	
	return $string;
	}
	
		
	/**
	 * Очистка строки с переводом тэга &lt;br /&gt; к \\r\\n и удаление HTML разметки.
	 * @param string $string Строка.
	 * @return string Очищенная строка.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getTextN($string)
	{
	$string = trim($string);
	$string = $this->parserBrToRn($string);
	$string = strip_tags($string);
	
	return $string;
	}
		
	
	/**
	 * Очистка строки с переводом каретки к тэгу &lt;br /&gt; и удаление HTML разметки.
	 * @param string $string Строка.
	 * @return string Очищенная строка.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getTextBr($string)
	{
	$string = trim($string);
	$string = strip_tags($string, "<br>,<br/>,<br />");
	$string = $this->parserRnToBr($string);
	
	return $string;
	}
		
	
	/**
	 * Очистка строки с переводом каретки к тэгу &lt;br /&gt; с сохранением HTML разметки.
	 * @param string $string Строка.
	 * @return string Очищенная строка.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getHtmlBr($string)
	{
	$string = trim($string);
	$string = $this->parserRnToBr($string);
	return $string;
	}	
	
	
	/**
	 * Очистка строки с сохранением HTML разметки.
	 * @param string $string Строка.
	 * @return string Очищенная строка.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getHtmlN($string)
	{
	$string = trim($string);
	return $string;
	}


	/**
	 * Преобразователь статусов для записи.
	 * @param string $type Тип получаемого значения: label - в виде метки, bool - в виде булево значения, number - в виде числа.
	 * @param string $value Текущее значение статуса.
	 * @return string|bool|int Результат преобразования.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getStatus($type, $value)
	{
        if($value == "Не активен" || $value === 0 || $value === false)
        {
            if($type == "label") return "Не активен";
            if($type == "bool") return false;
            if($type == "number") return 0;
        }
	    else if($value == "Активен" || $value === 1 || $value === true)
		{
			if($type == "label") return "Активен";
			if($type == "bool") return true;
			if($type == "number") return 1;
		}

	return $value;
	}


	/**
	 * Преобразователь булевых значений для записи.
	 * @param string $type Тип получаемого значения: label - в виде метки, bool - в виде булево значения, number - в виде числа.
	 * @param string|bool|int $value Текущее значение статуса.
	 * @return string|bool|int $value Результат преобразования.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getBool($type, $value)
	{
		if($value == "Нет" || $value === 0 || $value === false)
		{
			if($type == "label") return "Нет";
			if($type == "bool") return false;
			if($type == "number") return 0;
		}
		else if($value == "Да" || $value === 1 || $value === true)
        {
            if($type == "label") return "Да";
            if($type == "bool") return true;
            if($type == "number") return 1;
        }

		return $value;
	}

	
	/**
	 * Обработка строки с переводом тэга &lt;br /&gt; к \\r\\n.
	 * @param string $str Строка.
	 * @return string Очищенная строка.
	 * @since 1.0
	 * @version 1.0
	 */
	public function parserBrToRn($str)
	{
	$str = str_replace("<br />", "\r\n", $str);
	$str = str_replace("<br>", "\r\n", $str);
	return $str;
	}
	
	
	/**
	 * Обработка строки с переводом корретки к тэгу &lt;br /&gt;. 
	 * @param string $str Строка.
	 * @return string Очищенная строка.
	 * @since 1.0
	 * @version 1.0
	 */
	public function parserRnToBr($str)
	{
	$str = str_replace("\r\n", "<br />", $str);
	$str = str_replace("\n", "<br />", $str);
	$str = str_replace("\r", "<br />", $str);
	return $str;
	}
	
	
	
	/**
	 * Проверка длины строки.
	 * @param string $str Строка.
	 * @param int $min Минимальная длина.
	 * @param int $max Максимальная длина.
	 * @return bool Вернет true если длина удовлетворяет введенным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isLength($str, $min = null, $max = null)
	{
	$str = trim($str);
	$len = $this->strlen($str);
	
		if($len > $max && $max != null) return false;
		else if($len < $min && $min != null) return false;
		else return true;
	}
		
	
	/**
	 * Проверяет, содержит ли введенная переменная целым числом.
	 * @param mixed $num Число для проверки.
	 * @param bool $unsigned Если указать true, то число должно быть положительным.
	 * @param int $minLength Минимальная длина.
	 * @param int $maxLength Максимальная длина.
	 * @param int $minNumber Минимальное число.
	 * @param int $maxNumber Максимальное число.
	 * @return bool Вернет true если число удовлетворяет введенным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */	
	public function isInteger($num, $unsigned = false, $minLength = null, $maxLength = null, $minNumber = null, $maxNumber = null)
	{		
		if($minLength != null || $maxLength != null)
		{
		$how = $this->isLength($num, $minLength, $maxLength);
			if($how == false) return false;
		}		
		
		if($unsigned == true) $how = preg_match("/^[0-9]*$/", $num);
		else $how = preg_match("/^-?[0-9]*$/", $num);
	
		if($how == false) return false;
		else
		{
		$how = $this->isCorrectIntegerDiapozone($num, $minNumber, $maxNumber);
		return $how;
		}
	}
	
		
	/**
	 * Проверяет, содержит ли введенная переменная дробное числом.
	 * @param mixed $num Число для проверки.
	 * @param bool $unsigned Если указать true, то число должно быть положительным.
	 * @param int $minLength Минимальная длина.
	 * @param int $maxLength Максимальная длина.
	 * @param int $minNumber Минимальное число.
	 * @param int $maxNumber Максимальное число.
	 * @return bool Вернет true если число удовлетворяет введенным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isFloat($num, $unsigned = false, $minLength = null, $maxLength = null, $minNumber = null, $maxNumber = null)
	{		
		if($minLength != null || $maxLength != null)
		{
		$how = $this->isLength($num, $minLength, $maxLength);
			if($how == false) return false;
		}		
	
		if($unsigned == true) $how = preg_match("/^[0-9]*\.?[0-9]*$/", $num);
		else $how = preg_match("/^-?[0-9]*\.?[0-9]*$/", $num);
	
		if($how == false)return false;
		else
		{
		$how = $this->isCorrectIntegerDiapozone($num, $minNumber, $maxNumber);
		return $how;
		}
	}
	
	
	
	/**
	 * Проверяет, содержит ли строка только латинские символы без пробелов.
	 * @param string $value Строка для проверки.
	 * @param int $minLength Минимальная длина.
	 * @param int $maxLength Максимальная длина.
	 * @param bool $toLower Если указать true, то все символы должны быть в нижнем регистре.
	 * @return bool Вернет true если строка удовлетворяет введенным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */	
	public function isLatinica($value, $minLength, $maxLength, $toLower)
	{		
		if($minLength != null || $maxLength != null)
		{
		$how = $this->isLength($value, $minLength, $maxLength);
			if($how == false) return false;
		}		
	
		if($toLower == true) $how = preg_match("/^[a-z0-9_-]*$/", $value);
		else $how = preg_match("/^[a-zA-Z0-9_-]*$/", $value);
	
		if($how == false) return false;
		else
		{
		$how = $this->isLength($value, $minLength, $maxLength);
		return $how;
		}
	}
	
	
	/**
	 * Проверяет, содержит ли строка только символы и пробелы.
	 * @param string $value Строка для проверки.
	 * @param int $minLength Минимальная длина.
	 * @param int $maxLength Максимальная длина.
	 * @return bool Вернет true если строка удовлетворяет введенным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */	
	public function isAlpha($value, $minLength, $maxLength)
	{		
		if($minLength != null || $maxLength != null)
		{
		$how = $this->isLength($value, $minLength, $maxLength);
			if($how == false) return false;
		}		
	
	$how = preg_match("/^[^0-9]*$/", $value);
	
		if($how == false) return false;
		else
		{
		$how = $this->isLength($value, $minLength, $maxLength);
		return $how;
		}
	}
	
	
	
	/**
	 * Проверяет, содержит ли строка e-mail адрес.
	 * @param string $eMail Строка для проверки.
	 * @param bool $require Если указать true, то строка не должна быть пустой.
	 * @param bool $many Если указать true, то можно внести несколько электронных адресов через запятую.
	 * @return bool Вернет true если строка удовлетворяет введенным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */	
	public function isEmail($eMail, $require = false, $many = false)
	{
	$len = $this->strlen($eMail);
	
		if($require == true)
		{
		$how = $this->isLength($eMail, 1);
		
			if($how == false) return false;
		}
		else if($require == false && $len == 0) return true;
	
		if($many == true) $how = preg_match("/^([\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}(, ?)?)*$/", $eMail);
		else $how = preg_match("/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/", $eMail);
		
		if($how == false) return false;
		else return true;
	}


	/**
	 * Проверяет, содержит ли строка стоимость.
	 * @param string $money Строка для проверки.
	 * @param bool $require Если указать true, то строка не должна быть пустой.
	 * @return bool Вернет true если строка удовлетворяет введенным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isMoney($money, $require = false)
	{
	$len = $this->strlen($money);

		if($require == true)
		{
		$how = $this->isLength($money, 1);

			if($how == false) return false;
		}
		else if($require == false && $len == 0) return true;

	$is = $this->isFloat($money, true, 1);

		if($is == true) return true;

	$how = preg_match('/^(\d{1,3} ?)+(\,\d{1,2})?$/', $money);

		if($how == false) return false;
		else return true;
	}
	
	
	
	/**
	 * Проверяет, содержит ли строка url адрес.
	 * @param string $url Строка для проверки.
	 * @param bool $require Если указать true, то строка не должна быть пустой.
	 * @return bool Вернет true если строка удовлетворяет введенным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */	
	public function isUrl($url, $require = false)
	{
	$len = $this->strlen($url);
	
		if($require == true)
		{
		$how = $this->isLength($url, 1);
		
			if($how == false) return false;
		}
		else if($require == false && $len == 0)
		{
		return true;
		}
	
	$how = preg_match("/^((https?|ftp)\:\/\/){1}([a-zA-ZА-Яа-я0-9]{1})((\.[a-zA-ZА-Яа-я0-9-])|([a-zA-ZА-Яа-я0-9-]))*\.?([a-zA-ZА-Яа-я]{0,6})(\/[-_\w\.]*)*(\/?)(\??)([-_\w]*=?[ -_\w]*&?)*(#[-_\w]*)?$/", $url);
	
		if($how == false) return false;
		else return true;
	}
	
	
	/**
	 * Проверяет, содержит ли строка IP адрес.
	 * @param string $ip Строка для проверки.
	 * @param bool $require Если указать true, то строка не должна быть пустой.
	 * @return bool Вернет true если строка удовлетворяет введенным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */	
	public function isIp($ip, $require = false)
	{
	$len = $this->strlen($ip);
	
		if($require == true)
		{
		$how = $this->isLength($ip, 1);
		
			if($how == false) return false;
		}
		else if($require == false && $len == 0) return true;
	
	$how = preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $ip);
	
		if($how == false) return false;
		else return true;
	}
	
	
	
	/**
	 * Проверяет, входит ли число в заданный диапазон.
	 * @param int $number Число для проверки.
	 * @param int $min Минимальное число.
	 * @param int $max Максимальная число.
	 * @return bool Вернет true если число удовлетворяет введенным параметрам.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isCorrectIntegerDiapozone($number, $min, $max)
	{
	$isCorrect = true;
	
		if($min != null && $number < $min) $isCorrect = false;
		if($max != null && $number > $max) $isCorrect = false;
		
	return $isCorrect;
	}
	
	
	
	/**
	 * Производит перевод числа в денежный формат.
	 * @param int $price Строка для перевода.
	 * @return string Вернет строку в виде числа.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getMoneyFormat($price)
	{
	$priceArr = Array();
	$hasMin = false;

		if(stripos($price, "-") === 0)
		{
		$hasMin = true;
		$price = substr($price, 1, strlen($price));
		}
	
		if(is_double($price)) $price = round($price, 2);
	
	$priceAndCurrency = explode(" ", $price);
	$celAndOst = explode(".", $priceAndCurrency[0]);
	
		if(@$celAndOst[1] && $celAndOst[1] != "00")
		{
		$priceArr[0] = $celAndOst[0];
		$priceArr[1] = $celAndOst[1];
		$priceArr[2] = @$priceAndCurrency[1];
		}
		else
		{
		$priceArr[0] = $celAndOst[0];
		$priceArr[1] = 0;
		$priceArr[2] = @$priceAndCurrency[1];	
		}
	
	$lenPrice = $this->strlen(trim($priceArr[0])) - 1;
	
		if($lenPrice >= 3)
		{
		$priceForm = "";
		
			for($i = $lenPrice, $z = -1; $i >= 0; $i--)
			{				
				if($z == 2)
				{
				$priceForm = " ".$priceForm;
				$z = -1;
				}
							
			$priceForm = @$priceArr[0][$i].$priceForm;
			$z++;
			}
		
		$priceArr[0] = $priceForm;
		}
		
	$priceNew = $priceArr[0];
		
		if($priceArr[0] != "" && $priceArr[1] != "")
		{		
			if(strlen($priceArr[1]) == 2 && @$priceArr[1][1] == 0) $priceArr[1] = $priceArr[1][0];
			
		$priceNew = $priceArr[0].",".$priceArr[1];
		}

		if($hasMin == true) $priceNew = "-".$priceNew;
		
	return $priceNew;
	}

	
	
	/**
	 * Удаление всех лишних пробелов в строке.
	 * @param string $string Строка для очистки лишних пробелов.
	 * @return string Строка без лишних пробелов.
	 * @since 1.0
	 * @version 1.0
	 */
	public function deleteWhitespace($string)
	{ 
	$string = preg_replace('/ {2,}/',' ',$string); 
	$string = trim($string) ; 
	return $string;
	}
	
	
	/**
	 * Преобразует шестнадцатеричные данные в бинарные.
	 * @param string $hexdata Строка шестнадцатеричных данных.
	 * @return string Строка бинарных данных.
	 * @since 1.0
	 * @version 1.0
	 */
	public function hex2bin($hexdata)
	{
	$bindata = "";
	
		for ($i = 0; $i < strlen($hexdata); $i += 2)
		{
		$bindata .= chr(hexdec(substr($hexdata, $i, 2)));
		}
	
	return $bindata;
	}
	
	
	/**
	 * Выделяем в тексте требуемые слова.
	 * Эта специализированный метод для выделения в тексте требуемые слова и игнорирование HTML тэгов которые могут присутствовать в тексте.
	 * @param string $string Строка, которую нужно искать. Если это выражение, то оно будет разбито на несколько слов и отдельно будет искаться и выделяться по словесно.
	 * @param string $text Текст в котором производиться поиск и игнорирование HTML тэгов.
	 * @param string $nameClass Название класса у тэга, который будет служить выделению.
	 * @return string Текст с выделением.
	 * @since 1.0
	 * @version 1.0
	 */
	public function mark($string, $text, $nameClass = "matchtext")
	{
	$string = $this->getCorrectSearchStr($string);
	
		if($this->strlen($string) > 3)
		{
		$stringAr = explode(" ", $string);
		
			for($z = 0; $z < count($stringAr); $z++)
			{
			$stringCur = trim($stringAr[$z]);
			
				if($this->strlen($stringCur) < 2) continue;
				
				$text = preg_replace_callback("/(?<=^|>)[^><]+?(?=<|$)/", 
					function($m) use ($stringCur, $nameClass)
					{
					return preg_replace("/($stringCur)/iu", '<span class="'.$nameClass.'">$1</span>', $m[0]);
					}
				, $text);
			}
		}
		
	return $text;
	}
	
	
	/**
	 * Определем длину строки.
	 * Это безопаснаый метод определения длины строки текста независимо от кодировки.
	 * @param string $string Строка для перевода.
	 * @return int Длина строки.
	 * @since 1.0
	 * @version 1.0
	 */
	public function strlen($string)
	{	
		if(mb_detect_encoding($string) == "UTF-8") return mb_strlen($string, "UTF-8");
		else return strlen($string);
	}
	
	
	/**
	 * Транслирует текст.
	 * Переводит текст с русского языка.
	 * @param string $string Строка для перевода.
	 * @param string $separator Сепаратор, который используется в качестве пробела.
     * @param bool $symbols Если указать true, то допустит только буквы и и цифры, остальные символы будут удалены.
	 * @return string Транслируемая строка.
	 * @since 1.0
	 * @version 1.0
	 */
	public function latin($string, $separator = "-", $symbols = true)
	{ 
		$order = array
		(
		"а" => "a",
		"б" => "b",
		"в" => "v",
		"г" => "g",
		"д" => "d",
		"е" => "e",
		"ё" => "e",
		"ж" => "zh",
		"з" => "z",
		"и" => "i",
		"й" => "y",
		"к" => "k",
		"л" => "l",
		"м" => "m",
		"н" => "n",
		"о" => "o",
		"п" => "p",
		"р" => "r",
		"с" => "s",
		"т" => "t",
		"у" => "u",
		"ф" => "f",
		"х" => "h",
		"ц" => "c",
		"ч" => "ch",
		"ш" => "sh",
		"щ" => "sh",
		"ъ" => "",
		"ы" => "i",
		"ь" => "",
		"э" => "e",
		"ю" => "u",
		"я" => "ya",
		
		"А" => "A",
		"Б" => "B",
		"В" => "V",
		"Г" => "G",
		"Д" => "D",
		"Е" => "E",
		"Ё" => "E",
		"Ж" => "ZH",
		"З" => "Z",
		"И" => "I",
		"Й" => "Y",
		"К" => "K",
		"Л" => "L",
		"М" => "M",
		"Н" => "N",
		"О" => "O",
		"П" => "P",
		"Р" => "R",
		"С" => "S",
		"Т" => "T",
		"У" => "U",
		"Ф" => "F",
		"Х" => "H",
		"Ц" => "C",
		"Ч" => "CH",
		"Ш" => "SH",
		"Щ" => "SH",
		"Ъ" => "",
		"Ы" => "I",
		"Ь" => "",
		"Э" => "E",
		"Ю" => "U",
		"Я" => "Ya",
		
		"a" => "a",
		"b" => "b",
		"c" => "c",
		"d" => "d",
		"e" => "e",
		"f" => "f",
		"g" => "g",
		"h" => "h",
		"i" => "i",
		"j" => "j",
		"k" => "k",
		"l" => "l",
		"m" => "m",
		"n" => "n",
		"o" => "o",
		"p" => "p",
		"q" => "q",
		"r" => "r",
		"s" => "s",
		"t" => "t",
		"u" => "u",
		"v" => "v",
		"w" => "w",
		"x" => "x",
		"y" => "y",
		"z" => "z",
		
		"A" => "A",
		"B" => "B",
		"C" => "C",
		"D" => "D",
		"E" => "E",
		"F" => "F",
		"G" => "G",
		"H" => "H",
		"I" => "I",
		"J" => "J",
		"K" => "K",
		"L" => "L",
		"M" => "M",
		"N" => "N",
		"O" => "O",
		"P" => "P",
		"Q" => "Q",
		"R" => "R",
		"S" => "S",
		"T" => "T",
		"U" => "U",
		"V" => "V",
		"W" => "W",
		"X" => "X",
		"Y" => "Y",
		"Z" => "Z",
		
		"0" => "0",
		"1" => "1",
		"2" => "2",
		"3" => "3",
		"4" => "4",
		"5" => "5",
		"6" => "6",
		"7" => "7",
		"8" => "8",
		"9" => "9",	
		
		" " => $separator,
		$separator => $separator
		);

	$length = $this->strlen($string);
	$latin = "";
		
		for($i = 0; $i < $length; $i++)
		{
		$letter = mb_substr($string, $i, 1, "utf-8");
		
			if(isset($order[$letter])) $latin .= $order[$letter];
			else if($symbols == false) $latin .= $letter;
		}
	
	return $latin;
	}
	
	
	/**
	 * Переводит параметры в строку запроса для URL.
	 * @param array $params Параметры для перевода.
	 * @param array $allow Массив допустимых параметров, если не указать, то возьмет все параметры.
	 * @param array $disallow Массив не допустимых параметров, если не указать, то возьмет все параметры.
	 * @param string $startChar Символ, который нужно поставить в самом начале строки. Этот символ будет проставлен, только если сама строка имеет значение. В основном это символы ? или &.
	 * @return string Строка запроса для URL.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getUrlQuery($params, $allow = null, $disallow = null, $startChar = "")
	{
	$paramsAllow = Array();		
	
		foreach($params as $k => $v)
		{
			if($allow)
			{
				if(in_array($k, $allow) == false) continue;
			}
			
			if($disallow)
			{
				if(in_array($k, $disallow) == true) continue;
			}
		
		$paramsAllow[$k] = $v;
		}
		
	$query = http_build_query($paramsAllow);
		
		if($query != "" && $startChar != "") $query = $startChar.$query;
	
	return $query;
	}


	/**
	 * Метод перевода первого символа слова в верхний регистр.
	 * Этот метод заменяет стандартную функцию ucfirst, которая не работает в кодировке UTF-8.
	 * @param string $str Строка для перевода.
	 * @return string Возвращает слово с верхним регистром.
	 * @since 1.0
	 * @version 1.0
	 */
	public function ucfirst($str)
	{
	return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr($str, 1, mb_strlen($str)-1, 'utf-8');
	}


	/**
	 * Метод проверит является ли массив ассоциативным.
	 * @param array $arr Ассоциативный массив для проверки.
	 * @return string Возвращает true, если массив ассоциативный.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isAssoc($arr)
	{
		if(array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
}
?>