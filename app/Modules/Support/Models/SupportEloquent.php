<?php
/**
 * Модуль Поддержки.
 * Этот модуль содержит все классы для работы поддержкой в административной системе.
 * @package App.Modules.Support
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Support\Models;

use Eloquent;
use Util;
use Image;
use App\Models\Validate;

/**
 * Класс модель для поддержки на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idSupport ID записи.
 * @property string $email E-mail администратора.
 * @property string $fio ФИО администратора.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Support\Models\SupportEloquent whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Support\Models\SupportEloquent whereFio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Support\Models\SupportEloquent whereIdSupport($value)
 *
 * @mixin \Eloquent
 */
class SupportEloquent extends Eloquent
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
protected $table = 'support';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idSupport';

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
'idSupport',
'email',
'fio'
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
        'email' => 'required|email',
        'fio' => 'required|between:1,150'
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
        'email' => 'E-mail администратора',
        'fio' => 'ФИО администратора'
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
        'email' => 'Поле :attribute должно содержать корректный e-mail адрес.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: E-mail.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setEmailAttribute($value)
	{
	$this->attributes['email'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: ФИО.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setFioAttribute($value)
	{
	$this->attributes['fio'] = Util::getText($value);
	}
}