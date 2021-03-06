<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 * @package App.Modules.Document
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Document\Models;

use Eloquent;
use Util;
use App\Models\Validate;


/**
 * Класс модель для таблицы документов на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idDocument ID документа.
 * @property mixed $byte Байт код документа.
 * @property mixed $format Формат документа.
 * @property string $cache Предиката для кеширования.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Document\Models\DocumentEloquent whereIdDocument($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Document\Models\DocumentEloquent whereByte($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Document\Models\DocumentEloquent whereFormat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Document\Models\DocumentEloquent whereCache($value)
 *
 * @mixin \Eloquent
 */
class DocumentEloquent extends Eloquent
{
use Validate;

/**
 * Параметр для хранения пути к файлу.
 * @var string
 * @since 1.0
 * @version 1.0
 */
public $path;

/**
 * Параметр для хранения пути к файлу без кешь придикаты.
 * @var string
 * @since 1.0
 * @version 1.0
 */
public $pathCache;


/**
 * Параметр для хранения физического пути к файлу.
 * @var string
 * @since 1.0
 * @version 1.0
 */
public $pathSource;


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
protected $table = 'document';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idDocument';

/**
 * Определяет необходимость отметок времени для модели.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
public $timestamps = false;

/**
 * Расширенные пользователькие события.
 * @var array
 * @since 1.0
 * @version 1.0
 */
protected $observables = ['readed'];

/**
 * Атрибуты, для которых разрешено массовое назначение.
 * @var array
 * @since 1.0
 * @version 1.0
 */
protected $fillable =
[
'idDocument',
'byte',
'format',
'cache'
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
		'format' => 'required|between:1,20',
		'cache' => 'max:50'
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
		'byte' => 'Байт код документа',
		'format' => 'Формат документа',
		'cache' => 'Кеш предиката'
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
		'max' => 'Поле :attribute должно содержать не больше :max символов.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: формат документа.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setFormatAttribute($value)
	{
	$this->attributes['format'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: кеш предиката.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setСacheAttribute($value)
	{
	$this->attributes['cache'] = Util::getText($value);
	}


	/**
	 * Перегружаем стандартный метод для возможности запуска события на чтение.
	 * @param array $attributes Значения атрибутов.
	 * @param bool $sync Синхронизировать.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setRawAttributes(array $attributes, $sync = false)
	{
	parent::setRawAttributes($attributes, $sync);
	$this->fireModelEvent('readed');
	}
}