<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Models;

use Eloquent;
use App\Models\Validate;
use Util;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы обновления на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idUpload ID записи.
 * @property int $idModule ID модуля.
 * @property \Carbon\Carbon $nextDate Дата следующей версии.
 * @property string $nextVersion Следующая версия.
 *
 * @property-read \App\Modules\Module\Models\ModuleEloquent $Module Модуль.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Upload\Models\UploadEloquent whereIdModule($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Upload\Models\UploadEloquent whereIdUpload($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Upload\Models\UploadEloquent whereNextDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Upload\Models\UploadEloquent whereNextVersion($value)
 *
 * @mixin \Eloquent
 */
class UploadEloquent extends Eloquent
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
protected $table = 'upload';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $primaryKey = 'idUpload';

/**
 * Определяет необходимость отметок времени для модели.
 * @var bool
 * @version 1.0
 * @since 1.0
 */
public $timestamps = false;

/**
 * Атрибуты, которые должны быть преобразованы к дате.
 * @var array
 * @version 1.0
 * @since 1.0
 */
protected $dates =
[
'nextDate'
];

/**
 * Атрибуты, для которых разрешено массовое назначение.
 * @var array
 * @since 1.0
 * @version 1.0
 */
protected $fillable =
[
'idUpload',
'idModule',
'nextDate',
'nextVersion'
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
        'nextDate' => 'date',
        'nextVersion' => 'max:150'
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
        'nextDate' => 'Дата следющей версии',
        'nextVersion' => 'Номер версии'
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
		'max' => 'Поле :attribute должно содержать не больше :max символов.',
		'date' => 'Поле :attribute должно содержать корректную дату.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: следующая версия.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setNextVersionAttribute($value)
	{
	$this->attributes['nextVersion'] = Util::getText($value);
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
}