<?php
/**
 * Модуль Компонента страницы.
 * Этот модуль содержит все классы для работы с компонентами страницы.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponent\Models;

use Eloquent;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы компонентов страницы на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idPageComponent ID компонента страницы.
 * @property int $idComponent ID компонента.
 * @property int $idPage ID страницы.
 * @property int $numberBlock Номер блока в странице.
 * @property bool $weight Вес компонента в блоке страницы.
 *
 * @property-read \App\Modules\Component\Models\ComponentEloquent $Component
 * @property-read \App\Modules\Page\Models\PageEloquent $Page
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent[] $PageComponentSetting
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponent\Models\PageComponentEloquent whereIdPageComponent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponent\Models\PageComponentEloquent whereIdComponent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponent\Models\PageComponentEloquent whereIdPage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponent\Models\PageComponentEloquent whereNumberBlock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageComponent\Models\PageComponentEloquent whereWeight($value)
 *
 * @mixin \Eloquent
 */
class PageComponentEloquent extends Eloquent
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
protected $table = 'pageComponent';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idPageComponent';

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
'idPageComponent',
'idComponent',
'idPage',
'numberBlock',
'weight'
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
        'idComponent' => 'required|integer|digits_between:1,20',
        'idPage' => 'required|integer|digits_between:1,20',
        'numberBlock' => 'required|integer|digits_between:1,5',
        'weight' => 'required|integer|digits_between:1,5'
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
        'idComponent' => 'ID компонента',
        'idPage' => 'ID страницы',
        'numberBlock' => 'Номер блока',
        'weight' => 'Вес компонента в блоке'
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
		'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.'
		];
	}

    /**
     * Получить запись компонента.
     * @return \App\Modules\Component\Models\ComponentEloquent Модель Компонента.
     * @version 1.0
     * @since 1.0
     */
    public function Component()
    {
    return $this->belongsTo('App\Modules\Component\Models\ComponentEloquent', 'idComponent', 'idComponent');
    }

    /**
     * Получить запись страницы.
     * @return \App\Modules\Page\Models\PageEloquent Модель Страницы сайта.
     * @version 1.0
     * @since 1.0
     */
    public function Page()
    {
    return $this->belongsTo('App\Modules\Page\Models\PageEloquent', 'idPage', 'idPage');
    }

    /**
     * Получить запись выбранных страниц группы.
     * @return \App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent Модель настроек компонента.
     * @version 1.0
     * @since 1.0
     */
    public function PageComponentSetting()
    {
    return $this->hasMany('App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent', 'idPageComponent');
    }
}