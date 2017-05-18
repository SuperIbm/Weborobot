<?php
/**
 * Модуль Разделы административной системы.
 * Этот модуль содержит все классы для работы с разделами административной системы.
 * @package App.Modules.AdminSection
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\AdminSection\Models;

use App\Models\Tree\Arr\TreeArray;
use App\Models\Tree\Arr\NodeArrayTextN;


/**
 * Класс модель для таблицы разделов административной системы на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idAdminSection ID секции административной системы.
 * @property int $idModule ID модуля.
 * @property string $labelSection Лейбел секции.
 * @property string $bundle Пакет раздела административной системы.
 * @property string $iconSmall Маленькая иконка.
 * @property string $iconBig Большая икнока.
 * @property bool $menuLeft Размещать ли раздел в левом блоке.
 * @property string $pathToCss Путь к CSS для раздела.
 * @property string $pathToJs Путь к JS для раздела.
 * @property bool $weight Вес раздела в меню административной системы.
 * @property string $status Значение статуса.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRoleAdminSectionEloquent[] $UserRoleAdminSection
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent whereIdAdminSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent whereNameSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent whereLabelSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent whereBundle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent whereIconSmall($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent whereIconBig($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent whereMenuLeft($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent wherePathToCss($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent wherePathToJs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AdminSection\Models\AdminSectionEloquent active($status = true)
 *
 * @mixin \Eloquent
 */
class AdminSectionTreeArrayEloquent extends AdminSectionEloquent
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
	return "labelSection";
	}

	/**
	 * Получение названия столбца определяющего ID ссылки на предыдущий узел.
	 * @return string Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameReferen()
	{
	return "bundle";
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

    /**
     * Преобразователь атрибута - получение: раздел секции.
     * @param mixed $value Значение атрибута.
     * @return string Значение статуса.
     * @since 1.0
     * @version 1.0
     */
    public function getBundleAttribute($value)
    {
    return $value;
    }
}