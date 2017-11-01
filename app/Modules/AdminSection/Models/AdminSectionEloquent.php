<?php
/**
 * Модуль Разделы административной системы.
 * Этот модуль содержит все классы для работы с разделами административной системы.
 * @package App.Modules.AdminSection
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\AdminSection\Models;

use Eloquent;
use Util;
use Config;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Module\Models\ModuleEloquent $Module
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
class AdminSectionEloquent extends Eloquent
{
use Validate, SoftDeletes;

/**
 * Убрать конвектатор атрибутов к змейке.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
public static $snakeAttributes = false;

/**
 * Связанная с моделью таблица.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $table = 'adminSection';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idAdminSection';

/**
 * Определяет необходимость отметок времени для модели.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
public $timestamps = false;

/**
 * Атрибуты, для которых разрешено массовое назначение.
 * @var array
 * @since 1.0
 * @version 1.0
 */
protected $fillable =
[
'idAdminSection',
'idModule',
'labelSection',
'bundle',
'iconSmall',
'iconBig',
'menuLeft',
'pathToCss',
'pathToJs',
'weight',
'status'
];

	/**
	 * Метод, который должен вернуть все правила валидации.
	 * @version 1.0
	 * @since 1.0
	 */
	protected function getRules()
	{
		return
		[
        'idModule' => 'required|integer|digits_between:1,20',
		'labelSection' => 'required|between:1,100|unique:AdminSection,labelSection,'.$this->idAdminSection.',idAdminSection',
		'bundle' => 'required|in:Контент,Сервисы,Продажи,Управления,Продвижение,Система,CONTENT,MANEGER,SALES,SEO,SERVICES,SYSTEM',
		'iconSmall' => 'max:255',
		'iconBig' => 'max:255',
		'menuLeft' => 'required|boolean',
		'pathToCss' => 'required|between:1,255',
		'pathToJs' => 'required|between:1,255',
		'weight' => 'required|integer|digits_between:0,20',
		'status' => 'required|boolean'
		];
	}

	/**
	 * Метод, который должен вернуть все названия атрибутов.
	 * @version 1.0
	 * @since 1.0
	 */
	protected function getNames()
	{
		return
		[
		'idModule' => 'ID модуля',
		'labelSection' => 'Лейбел раздела',
		'bundle' => 'Пакет раздела',
		'iconSmall' => 'Маленькая иконка',
		'iconBig' => 'Большая иконка',
		'menuLeft' => 'Добавить в левое меню',
		'pathToCss' => 'Путь к CSS',
		'pathToJs' => 'Путь к JS',
		'weight' => 'Вес разедала',
		'status' => 'Статус'
		];
	}


	/**
	 * Метод, который должен вернуть все сообщения об ошибках.
	 * @version 1.0
	 * @since 1.0
	 */
	protected function getMessages()
	{
		return
		[
		'required' => 'Поле :attribute должно быть определено.',
		'integer' => 'Поле :attribute должно содержать число.',
		'between' => 'Поле :attribute должно быть длиней :min символов, но короче :max символов.',
		'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.',
		'max' => 'Поле :attribute должно содержать не больше :max символов.',
		'min' => 'Поле :attribute должно содержать не меньше :min символов.',
		'in' => 'Поле :attribute должно иметь один из следующих типов: :values.',
		'boolean' => 'Поле :attribute должно содержать булево значение.',

        'labelSection.unique' => 'Вы не можете добавить такой раздел, т.к. он уже есть в базе данных.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: метка секции.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setLabelSectionAttribute($value)
	{
	$this->attributes['labelSection'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: раздел секции.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setBundleAttribute($value)
	{
    $bundles = Config::get('adminsection.bundles');
    $found = false;

        foreach($bundles as $k => $v)
        {
            if($value == $v)
            {
            $this->attributes['bundle'] = $k;
            $found = true;
            break;
            }
        }

        if($found == false) $this->attributes['bundle'] = $value;
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
    $bundles = Config::get('adminsection.bundles');

        if(isset($bundles[$value])) return $bundles[$value];
        else return $value;
    }

	/**
	 * Преобразователь атрибута - запись: путь к маленькой иконки.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setIconSmallAttribute($value)
	{
	$this->attributes['iconSmall'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: путь к большой иконки.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setIconBigAttribute($value)
	{
	$this->attributes['iconBig'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: наличие раздела в левом меню.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setMenuLeftAttribute($value)
	{
	$this->attributes['menuLeft'] = Util::getBool("number", $value);
	}

	/**
	 * Преобразователь атрибута - получение: наличие раздела в левом меню.
	 * @param mixed $value Значение атрибута.
	 * @return string Значение статуса.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getMenuLeftAttribute($value)
	{
	return Util::getBool("label", $value);
	}

	/**
	 * Преобразователь атрибута - запись: путь к CSS файлу.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setPathToCssAttribute($value)
	{
	$this->attributes['pathToCss'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: путь к JS файлу.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setPathToJsAttribute($value)
	{
	$this->attributes['pathToJs'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: статус.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setStatusAttribute($value)
	{
	$this->attributes['status'] = Util::getStatus("number", $value);
	}

	/**
	 * Преобразователь атрибута - получение: статус.
	 * @param mixed $value Значение атрибута.
	 * @return string Значение статуса.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getStatusAttribute($value)
	{
	return Util::getStatus("label", $value);
	}

    /**
     * Получить запись модуля.
     * @return \App\Modules\Module\Models\ModuleEloquent Модель модуля.
     * @version 1.0
     * @since 1.0
     */
    public function Module()
    {
    return $this->hasOne('App\Modules\Module\Models\ModuleEloquent', 'idModule', 'idModule');
    }

	/**
	 * Получить запись выбранных разделов административной системы.
	 * @return \App\Modules\User\Models\UserRoleAdminSectionEloquent Модель выбранных разделов административной системы.
	 * @version 1.0
	 * @since 1.0
	 */
	public function UserRoleAdminSection()
	{
	return $this->hasMany('App\Modules\User\Models\UserRoleAdminSectionEloquent', 'idAdminSection');
	}

	/**
	 * Заготовка запроса активных записей.
	 * @param \Illuminate\Database\Eloquent\Builder $Query Запрос.
	 * @param bool $status Статус активности.
	 * @return \Illuminate\Database\Eloquent\Builder Построитель запросов.
	 * @since 1.0
	 * @version 1.0
	 */
	public function scopeActive($Query, $status = true)
	{
	return $Query->where($this->getTable().'.status', $status == true ? 1 : 0);
	}
}