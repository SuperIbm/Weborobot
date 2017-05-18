<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Models;

use MongoDb;
use Util;
use App\Models\Validate;


/**
 * Класс модель для таблицы изображений на основе MongoDb.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idImage ID изображения.
 * @property int $format Формат изображения.
 * @property mixed $byte Байт код изображения.
 * @property string $cache Предиката для кеширования.
 * @property int $width Ширина изображения.
 * @property int $height Высота изображения.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereIdImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereByte($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereFormat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereCache($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereHeight($value)
 *
 * @mixin \MongoDb
 */
class ImageMongoDb extends MongoDb
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
protected $collection = 'image';

/**
 * Тип соединения.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $connection = 'mongodb';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idImage';

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
'idImage',
'byte',
'format',
'cache',
'width',
'height'
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
		'cache' => 'max:50',
		'width' => 'required|integer|digits_between:1,5',
		'height' => 'required|integer|digits_between:1,5'
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
		'byte' => 'Байт код изображения',
		'format' => 'Формат изображения',
		'cache' => 'Кеш предиката',
		'width' => 'Ширина изображения',
		'height' => 'Высота изображения'
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
		'min' => 'Поле :attribute должно содержать не меньше :min символов.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: формат изображения.
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