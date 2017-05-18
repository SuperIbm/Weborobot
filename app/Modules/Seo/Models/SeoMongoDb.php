<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Models;

use MongoDb;
use App\Models\Validate;


/**
 * Класс модель для таблицы статистики сайта на основе MongoDB.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SeoMongoDb extends MongoDB
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
protected $collection = 'seo';

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
protected $primaryKey = 'idSeo';

/**
 * Определяет необходимость отметок времени для модели.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
public $timestamps = false;

/**
 * Атрибуты, которые должны быть преобразованы к дате.
 * @var array
 * @since 1.0
 * @version 1.0
 */
protected $dates =
[
'dateStat'
];

/**
 * Атрибуты, для которых разрешено массовое назначение.
 * @var array
 * @since 1.0
 * @version 1.0
 */
protected $fillable =
[
'idSeo',
'dateStat',
'visits',
'shows',
'visitors',
'visitorsNew'
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
		'idSeo' => 'integer|digits_between:0,20',
        'dateStat' => 'required|dateMongo',
        'visits' => 'required|integer|digits_between:0,20',
        'shows' => 'required|integer|digits_between:0,20',
        'visitors' => 'required|integer|digits_between:0,20',
        'visitorsNew' => 'required|integer|digits_between:0,20'
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
        'dateStat' => 'Дата статистики',
        'visits' => 'Визиты',
        'shows' => 'Просмотры',
        'visitors' => 'Посетители',
        'visitorsNew' => 'Новые посетители'
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
		'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.',
		'dateMongo' => 'Поле :attribute должно содержать корректную дату.'
		];
	}
}