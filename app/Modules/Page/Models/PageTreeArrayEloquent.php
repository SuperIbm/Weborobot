<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Page\Models;

use App\Models\Tree\Arr\TreeArray;


/**
 * Класс модель для таблицы страниц сайта с построением дерева в виде массива на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idPage
 * @property int $idPageTemplate ID шаблона страницы.
 * @property int $idPageReferen ID страницы потомка.
 * @property string $namePage Название страницы.
 * @property string $nameLink Ссылка на страницу.
 * @property string $description Описание страницы.
 * @property string $keywords Ключевые слова страницы.
 * @property string $title Заголовок страницы.
 * @property string $html HTML страницы.
 * @property int $weight Вес страницы в структуре сайта.
 * @property bool $showInMenu Статус показывать ли страницу в меню.
 * @property string $modeAccess Доступ к странице.
 * @property string $redirect URL для переадресации с этой страницы.
 * @property \Carbon\Carbon $dateEdit Дата обновления страницы.
 * @property string $status Значение статуса.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupPageEloquent[] $UserGroupPage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRolePageEloquent[] $UserRolePage
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereIdPage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereIdPageTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereIdPageReferen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereNamePage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereNameLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereKeywords($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereHtml($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereShowInMenu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereModeAccess($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereToUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereDateEdit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageTreeArrayEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent active($status = true)
 * 
 * @mixin \Eloquent
 */
class PageTreeArrayEloquent extends PageEloquent
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
	return "namePage";
	}

	/**
	 * Получение названия столбца определяющего ID ссылки на предыдущий узел.
	 * @return string Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameReferen()
	{
	return "idPageReferen";
	}


	/**
	 * Метод получения названия столбца определяющий вес узла.
	 * @return string Возвращает название столбца.
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