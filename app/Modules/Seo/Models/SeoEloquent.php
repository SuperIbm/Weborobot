<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Models;

use Eloquent;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы статистики сайта на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idSeo
 * @property \Carbon\Carbon $dateStat Дата статистики.
 * @property int $visits Визиты.
 * @property int $shows Просмотры.
 * @property int $visitors Посетители.
 * @property int $visitorsNew Новые посетители.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Seo\Models\SeoEloquent whereIdSeo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Seo\Models\SeoEloquent whereDateStat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Seo\Models\SeoEloquent whereVisits($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Seo\Models\SeoEloquent whereShows($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Seo\Models\SeoEloquent whereVisitors($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Seo\Models\SeoEloquent whereVisitorsNew($value)
 *
 * @mixin \Eloquent
 */
class SeoEloquent extends Eloquent
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
protected $table = 'seo';

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
        'dateStat' => 'required|date|unique:seo,dateStat,'.$this->idSeo.',idSeo',
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
		'date' => 'Поле :attribute должно содержать корректную дату.'
		];
	}
}