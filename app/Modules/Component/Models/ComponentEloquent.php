<?php
/**
 * Модуль Компонента.
 * Этот модуль содержит все классы для работы с компонентами системы.
 * @package App.Modules.Component
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Component\Models;

use Eloquent;
use Util;
use App\Models\Validate;

/**
 * Класс модель для таблицы компонента на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idComponent ID компонента.
 * @property int $idModule ID модуля.
 * @property string $controller Название контроллера.
 * @property string $nameComponent Название компонента.
 * @property string $labelComponent Лейбел компонента.
 * @property string $pathToCss Путь к CSS файлу.
 * @property string $pathToJs Путь к JavaScript файлу.
 * @property string $status Значение статуса.
 *
 * @property-read \App\Modules\Module\Models\ModuleEloquent $Module
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Component\Models\ComponentEloquent whereIdComponent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Component\Models\ComponentEloquent whereIdModule($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Component\Models\ComponentEloquent whereController($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Component\Models\ComponentEloquent whereNameComponent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Component\Models\ComponentEloquent whereLabelComponent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Component\Models\ComponentEloquent wherePathToCss($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Component\Models\ComponentEloquent wherePathToJs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Component\Models\ComponentEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Component\Models\ComponentEloquent active($status = true)
 *
 * @mixin \Eloquent
 */
class ComponentEloquent extends Eloquent
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
protected $table = 'component';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idComponent';

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
'idComponent',
'idModule',
'controller',
'nameComponent',
'labelComponent',
'pathToCss',
'pathToJs',
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
        'controller' => 'max:150',
        'nameComponent' => 'required|between:1,150',
        'labelComponent' => 'required|between:1,150',
        'pathToCss' => 'max:255',
        'pathToJs' => 'max:255',
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
        'controller' => 'Название контроллера',
        'nameComponent' => 'Название компонента',
        'labelComponent' => 'Лейбел компонента',
        'pathToCss' => 'Путь к CSS файлу',
        'pathToJs' => 'Путь к JavaScript файлу',
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
        'boolean' => 'Поле :attribute должно содержать булево значение.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: Контроллер.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setControllerAttribute($value)
	{
	$this->attributes['controller'] = Util::getText($value);
	}

    /**
     * Преобразователь атрибута - запись: Название компонента.
     * @param mixed $value Значение атрибута.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setNameComponentAttribute($value)
    {
    $this->attributes['nameComponent'] = Util::getText($value);
    }

    /**
     * Преобразователь атрибута - запись: Лейбел компонента.
     * @param mixed $value Значение атрибута.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setLabelComponentAttribute($value)
    {
    $this->attributes['labelComponent'] = Util::getText($value);
    }

    /**
     * Преобразователь атрибута - запись: Путь к CSS файлу.
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
     * Преобразователь атрибута - запись: Путь к JavaScript файлу.
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