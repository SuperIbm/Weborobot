<?php
/**
 * Модуль Псевдонимы.
 * Этот модуль содержит все классы для работы с псевдонимами.
 * @package App.Modules.Alias
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Alias\Models;

use Eloquent;
use Util;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы псевдонимов на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * 
 * @property int $idAlias ID псевдонима.
 * @property string $pattern Паттерн.
 * @property int $idPage ID страницы. 
 * @property string $status Значение статуса.
 * 
 * @property-read \App\Modules\Page\Models\PageEloquent $Page
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alias\Models\AliasEloquent whereIdAlias($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alias\Models\AliasEloquent wherePattern($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alias\Models\AliasEloquent whereIdPage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alias\Models\AliasEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alias\Models\AliasEloquent active($status = true)
 * 
 * @mixin \Eloquent
 */
class AliasEloquent extends Eloquent
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
protected $table = 'alias';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idAlias';

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
'idAlias',
'pattern',
'idPage',
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
		'pattern' => 'required|between:1,250|unique:alias,pattern,'.$this->idAlias.',idAlias',
		'idPage' => 'integer|digits_between:0,20',
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
		'pattern' => 'Паттерн',
		'idPage' => 'ID страницы',
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
		'between' => 'Поле :attribute должно быть длиней :min символов, но короче :max символов.',
		'boolean' => 'Поле :attribute должно содержать булево значение.',
		'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.',
        'integer' => 'Поле :attribute должно содержать число.',

		'pattern.unique' => 'Вы не можете добавить такой паттерн, т.к. он уже есть в базе данных.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: паттерн.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setPatternAttribute($value)
	{
	$this->attributes['pattern'] = Util::getText($value);
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
	 * Получить запись страницы.
	 * @return \App\Modules\Page\Models\PageEloquent Модель страницы сайта.
	 * @version 1.0
	 * @since 1.0
	 */
	public function Page()
	{
	return $this->hasOne('App\Modules\Page\Models\PageEloquent', 'idPage', 'idPage');
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