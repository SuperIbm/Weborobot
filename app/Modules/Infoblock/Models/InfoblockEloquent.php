<?php
/**
 * Модуль Инфоблоков.
 * Этот модуль содержит все классы для работы с инфоблоками.
 * @package App.Modules.Infoblock
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Infoblock\Models;

use Eloquent;
use Util;
use App\Models\Validate;

/**
 * Класс модель для таблицы инфоблоков на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idInfoblock ID инфоблока.
 * @property string $labelInfoblock Название инфоблока.
 * @property string $code Код инфоблока.
 * @property string $status Значение статуса.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Infoblock\Models\InfoblockEloquent active($status = true)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Infoblock\Models\InfoblockEloquent whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Infoblock\Models\InfoblockEloquent whereIdInfoblock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Infoblock\Models\InfoblockEloquent whereLabelInfoblock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Infoblock\Models\InfoblockEloquent whereStatus($value)
 *
 * @mixin \Eloquent
 */
class InfoblockEloquent extends Eloquent
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
protected $table = 'infoblock';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idInfoblock';

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
'idInfoblock',
'labelInfoblock',
'code',
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
        'labelInfoblock' => 'required|between:1,255|unique:infoblock,labelInfoblock,'.$this->idInfoblock.',idInfoblock',
        'code' => 'between:0,65000',
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
        'labelInfoblock' => 'Название инфоблока',
        'code' => 'Код инфоблока',
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
        'labelInfoblock.unique' => 'Вы не можете добавить такой инфоблок, т.к. он уже есть в базе данных.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: название инфоблока.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setLabelInfoblockAttribute($value)
	{
	$this->attributes['labelInfoblock'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: код инфоблока.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setCodeAttribute($value)
	{
	$this->attributes['code'] = Util::getHtmlN($value);
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