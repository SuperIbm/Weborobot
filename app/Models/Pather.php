<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */
namespace App\Models;

use Util;
use Config;


/**
 * Класс для получения различных путей.
 * Специализированный класс, который позволяет получать пути к корню сайта, к разделам, где находиться пользователь.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Pather
{
	/**
	 * Получение разделителя для физических директорий.
	 * @return string Разделитель.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getFizDirSepDefault()
	{
	return DIRECTORY_SEPARATOR;
	}


	/**
	 * Получение физического пути к корню сервера.
	 * @return string Путь к корню сервера.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getFizPathToRoot()
	{
		if($this->getFizDirSepDefault() == "\\")
		{
		$pathToRoot = str_replace("/", "\\", $_SERVER["DOCUMENT_ROOT"]);
		$endChar = substr($pathToRoot, strlen($pathToRoot) - 1, strlen($pathToRoot));

			if($endChar != "\\") $pathToRoot .= "\\";
		}
		else $pathToRoot = $_SERVER["DOCUMENT_ROOT"];

	return $pathToRoot;
	}


	/**
	 * Получение полного физического пути к сайту.
	 * @return string Путь к корню сайта.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getFizFullPathToSite()
	{
	return dirname(dirname(__FILE__)).$this->getFizDirSepDefault();
	}


	/**
	 * Получение относительного физического пути к сайту.
	 * @return string Путь к корню сайта.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getFizPathToSite()
	{
	$getFizPathToSite = str_replace($this->getFizPathToRoot(), "", $this->getFizFullPathToSite());
	$getFizPathToSite = substr($getFizPathToSite, 0, strlen($getFizPathToSite) - 1);

	return $getFizPathToSite;
	}



	/**
	 * Получение относительного URL пути к сайту.
	 * @return string URL путь к сайту.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getUrlPathToSite()
	{
	$getUrlPathToSite = str_replace("\\", "/", $this->getFizPathToSite());

		if(@$getUrlPathToSite[0] == "/") $getUrlPathToSite = substr($getUrlPathToSite, 1, strlen($getUrlPathToSite));
		if(@$getUrlPathToSite[strlen($getUrlPathToSite) - 1] != "/") $getUrlPathToSite .= "/";

	return $getUrlPathToSite;
	}


	/**
	 * Получение доменного имени сайта.
	 * @param bool $protocol Если указать true, то вернет название доменного имени вместе с протоколом.
	 * @return string Доменное имя сайта.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getDomanName($protocol = true)
	{
		if(Config::get('app.url'))
		{
			if($protocol) return Config::get('app.url');
			else return parse_url(Config::get('app.url'), PHP_URL_HOST);
		}
		else
		{
			if($protocol) return $this->getProtocol()."://".$_SERVER["SERVER_NAME"]."/";
			else return $_SERVER["SERVER_NAME"];
		}

	}


	/**
	 * Получаем протокол через который запрашивается сайт.
	 * @return string Доменное имя сайта.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getProtocol()
	{
		return isset($_SERVER['HTTP_SCHEME']) ? $_SERVER['HTTP_SCHEME'] :
		(
			(
				(
					isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'
				) ||  443 == $_SERVER['SERVER_PORT']
			) ? 'https' : 'http'
		);
	}



	/**
	 * Получение относительного URL пути к сайту для cookie.
	 * @return string URL путь к сайту для cookie.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getUrlPathToSiteForCookie()
	{
	$getFizPathToSite = $this->getFizPathToSite();

		if($getFizPathToSite != "")
		{
			if($getFizPathToSite[0] != "/") $getFizPathToSite = "/".$getFizPathToSite;

		return $getFizPathToSite."/";
		}
		else return "/";
	}


	/**
	 * Получение чистого пути к запрашиваемому пользователем разделу сайта.
	 * @param bool $get Если указать true, то вернет URL вместе с GET.
	 * @return string Путь к разделу.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getUrlPathToSection($get = false)
	{
	$getUrlPathToSiteForCookie = $this->getUrlPathToSiteForCookie();

		if($getUrlPathToSiteForCookie != "/") $getUrlPathToSection = str_replace($getUrlPathToSiteForCookie, "", $_SERVER["REQUEST_URI"]);
		else $getUrlPathToSection = substr($_SERVER["REQUEST_URI"], 1, strlen($_SERVER["REQUEST_URI"]));

		if($get == false) $getUrlPathToSection = str_replace("?".$_SERVER["QUERY_STRING"], "", $getUrlPathToSection);

	$endChar = substr($getUrlPathToSection, strlen($getUrlPathToSection) - 1, strlen($getUrlPathToSection));

		if($endChar != "/" && strlen($getUrlPathToSection) != 0 && ($_SERVER["QUERY_STRING"] == "" || $get == false)) $getUrlPathToSection = $getUrlPathToSection."/";

	return $getUrlPathToSection;
	}


	/**
	 * Получение массива названий всех папок к запрашиваемому разделу пользователем.
	 * @param string $path Если указать путь, то он будет использован для разбора, если не указать, то будет путь запрошенный пользователем.
	 * @return array Массив названий всех папок.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getUrlAllDirToSection($path = null)
	{
	$path = $path === null ? $this->getUrlPathToSection() : $path;

		if($path)
		{
		$getUrlAllDirToSection = explode("/", "/".$path);
		unset($getUrlAllDirToSection[count($getUrlAllDirToSection) - 1]);

		return $getUrlAllDirToSection;
		}
		else return array();

	}


	/**
	 * Получение секции URL по его порядковому номеру.
	 * @param int $index Если указать порядковый номер, вернет только его значение. Если не указывать, то вернет все секции URL.
	 * @param mixed $default Если параметр не задан, то вернуть это значение по умолчанию.
	 * @param bool $fromEnd Если указать true, то начнет отчет с конца.
	 * @return mixed Секции URL.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getUrlSections($index = null, $fromEnd = false, $default = null)
	{
	$sections = $this->getUrlAllDirToSection();

		if(isset($index) == true)
		{
			if($fromEnd == true) $index = count($sections) - $index - 1;
			else $index++;

			if(isset($sections[$index])) return @$sections[$index];
			else
			{
				if(is_string($default) || is_int($default) || is_array($default) || is_bool($default) || is_object($default)) return $default;
				else if(@function_exists($default)) return call_user_func_array($default, array());
				else return null;
			}
		}
		else return $sections;
	}


	/**
	 * Получение массива всех путей, по которым можно пройти до текущей папки, которую запрашивает пользователь.
	 * @param string $path Если указать путь, то он будет использован для разбора, если не указать, то будет путь запрошенный пользователем.
	 * @return array Массив названий всех путей.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getUrlAllPathToSection($path = null)
	{
	$getUrlAllPathToSection = Array();
	$getUrlAllPathToSection[0] = "";
	$pathCurrent = "";
	$getUrlAllDirToSection = $path == null ? $this->getUrlAllDirToSection() : $this->getUrlAllDirToSection($path);

		for($i = 0; $i < count($getUrlAllDirToSection); $i++)
		{
			if($getUrlAllDirToSection[$i] == "") continue;

		$pathCurrent .= $getUrlAllDirToSection[$i]."/";
		$getUrlAllPathToSection[count($getUrlAllPathToSection)] = $pathCurrent;
		}

	return $getUrlAllPathToSection;
	}


	/**
	 * Получение реального IP адреса пользователя.
	 * Если получить реальный адрес IP не возможно, тогда берет локальный адрес 127.0.0.1
	 * @return string Возвращает реальный IP адрес пользователя.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getUserIp()
	{
		if(isset($_SERVER["HTTP_CLIENT_IP"])) $ip = $_SERVER["HTTP_CLIENT_IP"];
		elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		elseif (isset($_SERVER["HTTP_X_FORWARDED"])) $ip = $_SERVER["HTTP_X_FORWARDED"];
		elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) $ip = $_SERVER["HTTP_FORWARDED_FOR"];
		elseif (isset($_SERVER["HTTP_FORWARDED"])) $ip = $_SERVER["HTTP_FORWARDED"];
		elseif (isset($_SERVER["HTTP_X_REAL_IP"])) $ip = $_SERVER["HTTP_X_REAL_IP"];
		else $ip = $_SERVER["REMOTE_ADDR"];

		if(Util::isIp($ip)) return $ip;
		else return "127.0.0.1";
	}


	/**
	 * Определяет является ли данный пользователь ботом поисковой системы.
	 * @return bool Вернет true если это бот поисковой системы.
	 * @since 1.0
	 * @version 1.0
	 */
	public function isBot()
	{
		$engines = array
		(
			array("Aport", "Aport robot"),
			array("Google", "Google"),
			array("msnbot", "MSN"),
			array("Rambler", "Rambler"),
			array("Yahoo", "Yahoo"),
			array("AbachoBOT", "AbachoBOT"),
			array("accoona", "Accoona"),
			array("AcoiRobot", "AcoiRobot"),
			array("ASPSeek", "ASPSeek"),
			array("CrocCrawler", "CrocCrawler"),
			array("Dumbot", "Dumbot"),
			array("FAST-WebCrawler", "FAST-WebCrawler"),
			array("GeonaBot", "GeonaBot"),
			array("Gigabot", "Gigabot"),
			array("Lycos", "Lycos spider"),
			array("MSRBOT", "MSRBOT"),
			array("Scooter", "Altavista robot"),
			array("AltaVista", "Altavista robot"),
			array("WebAlta", "WebAlta"),
			array("IDBot", "ID-Search Bot"),
			array("eStyle", "eStyle Bot"),
			array("Mail.Ru", "Mail.Ru Bot"),
			array("Scrubby", "Scrubby robot"),
			array("Yandex", "Yandex"),
			array("YaDirectBot", "Yandex Direct"),
			array("Bot", "Unknow bot")
		);

	$userAgent = Util::toLower($_SERVER["HTTP_USER_AGENT"]);

		foreach($engines as $engine)
		{
			if(strstr($userAgent, Util::toLower($engine[0]))) return true;
		}

	return false;
	}
}
?>