<?php
/**
 * Модуль Настройки компонента страницы.
 * Этот модуль содержит все классы для работы настройками компонента на странице.
 * @package App.Modules.PageComponentSetting
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponentSetting\Models;

use Eloquent;
use Util;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы настроек компонента страницы на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * 
 * @property int $idPageComponentSetting ID настройки компонента на странице.
 * @property int $idPageComponent ID компонента на странице.
 * @property string $nameSetting Название настройки.
 * @property string $value Значение настройки.
 * 
 * @property-read \App\Modules\PageComponent\Models\PageComponentEloquent $PageComponent
 * 
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent whereIdPageComponentSetting($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent whereIdPageComponent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent whereNameSetting($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent whereValue($value)
 * 
 * @mixin \Eloquent
 */
class PageComponentSettingEloquent extends Eloquent
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
protected $table = 'pageComponentSetting';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idPageComponentSetting';

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
'idPageComponentSetting',
'idPageComponent',
'nameSetting',
'value'
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
        'idPageComponent' => 'integer|digits_between:0,20',
        'nameSetting' => 'required|between:1,255',
        'value' => 'max:255'
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
        'idPageComponent' => 'Компонент страницы',
        'nameSetting' => 'Название настройки',
        'value' => 'Значение настройки'
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
		'max' => 'Поле :attribute должно содержать не больше :max символов.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: Название настройки.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setNameSettingAttribute($value)
	{
	$this->attributes['nameSetting'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: Значение настройки.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setValueAttribute($value)
	{
	$this->attributes['value'] = Util::getText($value);
	}

	/**
	 * Получить запись выбранных разделов административной системы.
	 * @return \App\Modules\PageComponent\Models\PageComponentEloquent Модель компонента страницы.
	 * @version 1.0
	 * @since 1.0
	 */
	public function PageComponent()
	{
	return $this->belongsTo('App\Modules\PageComponent\Models\PageComponentEloquent', 'idPageComponent', 'idPageComponent');
	}
}