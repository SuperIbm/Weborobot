<?php
/**
 * Шаблонизатор Smarty.
 * Этот пакет содержит классы для расширения шаблонизатора Smarty.
 * @package App.Models.Smarty
 * @since 1.0
 * @version 1.0
 */
namespace App\Models\Smarty;

use \Smarty_Resource_Custom;
use App;


/**
 * Специализированный класс определющий новый тип ресурса для получения шаблона Smarty через шаблоны компонентов.
 * Этот класс служит связующим звеном между стандартным Smarty и шаблонами компонентов, которые хранятся в базе данных.
 * По сути говоря он позволяет Smarty получать шаблоны компонентов, что храняться в базе данных в таблце шаблонов компонента.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SmartyResourceComponentTemplate extends Smarty_Resource_Custom
{
	/**
	 * Получить шаблон и его модификаторы времени из базы данных.
	 * @param string $name Название шаблона.
	 * @param string $source Источник шаблона.
	 * @param integer $mtime Модификатор времени изменения таймстемп шаблона.
	 * @return void
	 */
	protected function fetch($name, &$source, &$mtime)
	{
	$Repository = App::make('App\Modules\ComponentTemplate\Repositories\ComponentTemplate');
	$record = $Repository->get($name, true);
	
		if($record)
		{
		$source = $record["htmlTpl"] ? $record["htmlTpl"] : "";
		$mtime = $this->fetchTimestamp($name);
		}
		else
		{
		$source = null;
		$mtime = null;	
		}
	}
	
	/**
	 * Получить модификатор времени шаблона из базы данных.
	 * @param string $name Название шаблона.
	 * @return int Таймстемп шаблона когда он был изменен.
	 */
	protected function fetchTimestamp($name)
    {
	return true;
    }
}
?>