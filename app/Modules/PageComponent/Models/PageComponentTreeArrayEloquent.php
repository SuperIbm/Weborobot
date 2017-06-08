<?php
/**
 * Модуль Компонента страницы.
 * Этот модуль содержит все классы для работы с компонентами страницы.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponent\Models;

use App\Models\Tree\Arr\TreeArray;
use App\Models\Tree\Arr\NodeArrayTextN;


/**
 * Класс модель для таблицы компонентов страницы сайта с построением дерева в виде массива на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idPageComponent ID компонента страницы.
 * @property int $idComponent ID компонента.
 * @property int $idPage ID страницы.
 * @property int $numberBlock Номер блока в странице.
 * @property bool $weight Вес компонента в блоке страницы.
 *
 * @property-read \App\Modules\Component\Models\ComponentEloquent $PageTemplate
 * @property-read \App\Modules\Page\Models\PageEloquent $Page
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponent\Models\PageComponentEloquent whereIdPageComponent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponent\Models\PageComponentEloquent whereIdComponent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponent\Models\PageComponentEloquent whereIdPage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponent\Models\PageComponentEloquent whereNumberBlock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponent\Models\PageComponentEloquent whereWeight($value)
 *
 * @mixin \Eloquent
 */
class PageComponentTreeArrayEloquent extends PageComponentEloquent
{
use TreeArray;

	/**
	 * Метод получения названия столбца определяющий название в узле.
	 * @return string Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameValue()
	{
	return "nameComponent";
	}

	/**
	 * Получение названия столбца определяющего ID ссылки на предыдущий узел.
	 * @return string Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameReferen()
	{
	return "numberBlock";
	}


	/**
	 * Метод получения названия столбца определяющий вес узла.
	 * @return string|array Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameWeight()
	{
	return "weight";
	}


	/**
	 * Метод получения объекта узла.
	 * @return \App\Models\Tree\Node Объект узла древовидной структуры.
	 * @since 1.0
	 * @version 1.0
	 */
	protected function _getNodeObject()
	{
	return new NodeArrayTextN();
	}
}