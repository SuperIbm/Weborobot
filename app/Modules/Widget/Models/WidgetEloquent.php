<?php
/**
 * Модуль Виджеты.
 * Этот модуль содержит все классы для работы с виджетами.
 * @package App.Modules.Widget
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Widget\Models;

use Eloquent;
use Util;
use App\Models\Validate;

/**
 * Класс модель для таблицы виджетов на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idWidget ID виджета.
 * @property int $idModule ID модуля.
 * @property string $actionWidget Название виджета.
 * @property string $labelWidget Лейбел виджета.
 * @property string $icon Путь к иконке.
 * @property string $pathToCss Путь к CSS файлу.
 * @property string $pathToJs Путь к JavaScript файлу.
 * @property string $def Значение статуса по умолчанию.
 * @property string $status Значение статуса.
 *
 * @property-read \App\Modules\Module\Models\ModuleEloquent $Module
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Widget\Models\WidgetEloquent whereIdWidget($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Widget\Models\WidgetEloquent whereIdModule($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Widget\Models\WidgetEloquent whereActionWidget($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Widget\Models\WidgetEloquent whereLabelWidget($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Widget\Models\WidgetEloquent whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Widget\Models\WidgetEloquent wherePathToCss($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Widget\Models\WidgetEloquent wherePathToJs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Widget\Models\WidgetEloquent whereDef($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Widget\Models\WidgetEloquent whereStatus($value)
 *
 * @mixin \Eloquent
 */
class WidgetEloquent extends Eloquent
{
use Validate;
    
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
protected $table = 'widget';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idWidget';

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
'idWidget',
'idModule',
'actionWidget',
'labelWidget',
'icon',
'pathToCss',
'pathToJs',
'def',
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
        'actionWidget' => 'required|between:1,150',
        'labelWidget' => 'required|between:1,150',
        'icon' => 'max:255',
        'pathToCss' => 'max:255',
        'pathToJs' => 'required|between:1,255',
        'def' => 'required|boolean',
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
        'actionWidget' => 'Название виджета',
        'labelWidget' => 'Лейбел виджета',
        'icon' => 'Путь к иконке',
        'pathToCss' => 'Путь к CSS',
        'pathToJs' => 'Путь к JavaScript',
        'def' => 'Статус по умолчанию',
        'status' => 'Статус активности'
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
        'boolean' => 'Поле :attribute должно содержать булево значение.',
		];
	}

	/**
	 * Преобразователь атрибута - запись: Название виджета.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setActionWidgetAttribute($value)
	{
	$this->attributes['actionWidget'] = Util::getText($value);
	}

    /**
     * Преобразователь атрибута - запись: Лейбел виджета.
     * @param mixed $value Значение атрибута.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setLabelWidgetAttribute($value)
    {
    $this->attributes['labelWidget'] = Util::getText($value);
    }

    /**
     * Преобразователь атрибута - запись: Путь к иконке.
     * @param mixed $value Значение атрибута.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setIconAttribute($value)
    {
    $this->attributes['icon'] = Util::getText($value);
    }

    /**
     * Преобразователь атрибута - запись: Путь к CSS.
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
     * Преобразователь атрибута - запись: Путь к JavaScript.
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
     * Преобразователь атрибута - запись: Статус по умолчанию.
     * @param mixed $value Значение атрибута.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setDefAttribute($value)
    {
    $this->attributes['def'] = Util::getBool("number", $value);
    }

    /**
     * Преобразователь атрибута - получение: Статус по умолчанию.
     * @param mixed $value Значение атрибута.
     * @return string Значение статуса.
     * @since 1.0
     * @version 1.0
     */
    public function getDefAttribute($value)
    {
    return Util::getBool("label", $value);
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
	 * Получить запись компонента.
	 * @return \App\Modules\Module\Models\ModuleEloquent Модель компонента.
	 * @version 1.0
	 * @since 1.0
	 */
	public function Module()
	{
	return $this->hasOne('App\Modules\Module\Models\ModuleEloquent', 'idModule', 'idModule');
	}

    /**
     * Заготовка запроса виджеты по умолчанию.
     * @param \Illuminate\Database\Eloquent\Builder $Query Запрос.
     * @param bool $status Статус активности.
     * @return \Illuminate\Database\Eloquent\Builder Построитель запросов.
     * @since 1.0
     * @version 1.0
     */
    public function scopeDef($Query, $status = true)
    {
    return $Query->where('def', $status == true ? 1 : 0);
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
    return $Query->where('status', $status == true ? 1 : 0);
    }
}