<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */
namespace App\Models;

use Illuminate\View\FileViewFinder;
use Util;
use InvalidArgumentException;
use App;

/**
 * Класс драйвер для поиска шаблонов.
 * Это расширенный класс, который позволяет искать не только шаблоны в виде файлов, но и в виде шаблонов компонентов в базе данных.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FileComponentViewFinder extends FileViewFinder
{
	/**
	 * Получение полного пути к запрашиваемому шаблону.
	 * @param string $name Название шаблона.
	 * @return string Путь к шаблону.
	 * @version 1.0
	 * @since 1.0
	 */
	public function find($name)
	{
		if(isset($this->views[$name])) return $this->views[$name];

		if($this->hasHintInformation($name = trim($name))) return $this->views[$name] = $this->findNamedPathView($name);

	$extension = substr($name, Util::strlen($name) - 6, Util::strlen($name));

		if($extension == ".tpldb")
		{
		$id = substr($name, 0, Util::strlen($name) - 6);
		$Repository = App::make('App\Modules\ComponentTemplate\Repositories\ComponentTemplate');
		$record = $Repository->get($id, true);

			if($record)	return $this->views[$name] = $name;
			else throw new InvalidArgumentException("View [$name] not found.");
		}
		else return $this->views[$name] = $this->findInPaths($name, $this->paths);
	}
}