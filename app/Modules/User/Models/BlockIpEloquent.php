<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\User\Models;

use Eloquent;
use Util;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы блокированных IP адресов на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idBlockIp ID блокированного IP адреса.
 * @property string $id Маски IP адреса.
 * @property string $status Значение статуса.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\BlockIpEloquent active($status = true)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\BlockIpEloquent whereIdBlockIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\BlockIpEloquent whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\BlockIpEloquent whereStatus($value)
 *
 * @mixin \Eloquent
 */
class BlockIpEloquent extends Eloquent
{
use Validate, SoftDeletes;

/**
 * Убрать конвектатор атрибутов к змейке.
 * @var bool
 * @version 1.0
 * @since 1.0
 */
public static $snakeAttributes = false;

/**
 * Связанная с моделью таблица.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $table = 'blockIp';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $primaryKey = 'idBlockIp';

/**
 * Определяет необходимость отметок времени для модели.
 * @var bool
 * @version 1.0
 * @since 1.0
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
'idBlockIp',
'ip',
'status'
];

	/**
	 * Метод, который должен вернуть все правила валидации.
	 * @see \App\Models\Validate::getRules
	 * @version 1.0
	 * @since 1.0
	 */
	protected function getRules()
	{
		return
		[
		'ip' => 'required|ipMask|unique:blockIp,ip,'.$this->idBlockIp.',idBlockIp',
		'status' => 'required|boolean'
		];
	}

	/**
	 * Метод, который должен вернуть все названия атрибутов.
	 * @see \App\Models\Validate::getNames
	 * @version 1.0
	 * @since 1.0
	 */
	protected function getNames()
	{
		return
		[
		'ip' => 'Маска IP',
		'status' => 'Статус'
		];
	}


	/**
	 * Метод, который должен вернуть все сообщения об ошибках.
	 * @see \App\Models\Validate::getMessages
	 * @version 1.0
	 * @since 1.0
	 */
	protected function getMessages()
	{
		return
		[
		'required' => 'Поле :attribute должно быть определено.',
		'ipMask' => 'Поле :attribute должно содержать корректную маску IP.',
		'boolean' => 'Поле :attribute должно содержать булево значение.',

		'ip.unique' => 'Вы не можете добавить такую маску IP, т.к. она уже есть в базе данных.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: IP.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function setIpAttribute($value)
	{
	$this->attributes['ip'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: статус.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function setStatusAttribute($value)
	{
	$this->attributes['status'] = Util::getStatus("number", $value);
	}

	/**
	 * Преобразователь атрибута - получение: статус.
	 * @param mixed $value Значение атрибута.
	 * @return string Значение статуса.
	 * @version 1.0
 	 * @since 1.0
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
	 * @version 1.0
 	 * @since 1.0
	 */
	public function scopeActive($Query, $status = true)
	{
	return $Query->where($this->getTable().'.status', $status == true ? 1 : 0);
	}
}