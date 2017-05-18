<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;
use Util;
use App\Models\Validate;


/**
 * Класс модель для таблицы страниц сайта на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * 
 * @property int $idPage ID страницы.
 * @property int $idPageTemplate ID шаблона страницы.
 * @property int $idPageReferen ID страницы потомка.
 * @property string $namePage Название страницы.
 * @property string $nameLink Ссылка на страницу.
 * @property string $description Описание страницы.
 * @property string $keywords Ключевые слова страницы.
 * @property string $title Заголовок страницы.
 * @property string $html HTML страницы.
 * @property int $weight Вес страницы в структуре сайта.
 * @property bool $showInMenu Статус показывать ли страницу в меню.
 * @property string $modeAccess Доступ к странице.
 * @property string $redirect URL для переадресации с этой страницы.
 * @property \Carbon\Carbon $dateEdit Дата обновления страницы.
 * @property string $status Значение статуса.
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupPageEloquent[] $UserGroupPage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRolePageEloquent[] $UserRolePage
 * 
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereIdPage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereIdPageTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereIdPageReferen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereNamePage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereNameLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereKeywords($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereHtml($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereShowInMenu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereModeAccess($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereToUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereDateEdit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Page\Models\PageEloquent active($status = true)
 * 
 * @mixin \Eloquent
 */
class PageEloquent extends Model
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
protected $table = 'page';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idPage';

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
'dateEdit'
];

/**
 * Атрибуты, для которых разрешено массовое назначение.
 * @var array
 * @since 1.0
 * @version 1.0
 */
protected $fillable =
[
'idPage',
'idPageTemplate',
'idPageReferen',
'namePage',
'nameLink',
'description',
'keywords',
'title',
'html',
'weight',
'showInMenu',
'modeAccess',
'redirect',
'dateEdit',
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
		'idPageTemplate' => 'integer|digits_between:0,20',
		'idPageReferen' => 'required|integer|digits_between:1,20',
		'namePage' => 'required|between:1,255',
		'nameLink' => 'required|between:1,255|alpha_dash',
		'description' => 'max:1000',
		'keywords' => 'max:1000',
		'title' => 'max:255',
		'html' => 'max:16777215',
		'weight' => 'required|integer|digits_between:0,20',
		'showInMenu' => 'required|boolean',
		'modeAccess' => 'required|in:INHERIT,FREE,NOT FREE',
		'redirect' => 'url',
		'dateEdit' => 'required|date',
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
		'idPageTemplate' => 'ID шаблона страницы',
		'idPageReferen' => 'ID родительской страницы',
		'namePage' => 'Название',
		'nameLink' => 'Ссылка',
		'description' => 'Описание',
		'keywords' => 'Ключевые слова',
		'title' => 'Заголовок',
		'html' => 'Код страницы',
		'weight' => 'Вес страницы',
		'showInMenu' => 'Показывать в меню',
		'modeAccess' => 'Доступ к странице',
		'redirect' => 'Ссылка переадресации',
		'dateEdit' => 'Дата обновления страницы',
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
		'integer' => 'Поле :attribute должно содержать число.',
		'between' => 'Поле :attribute должно быть длиней :min символов, но короче :max символов.',
		'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.',
		'max' => 'Поле :attribute должно содержать не больше :max символов.',
		'min' => 'Поле :attribute должно содержать не меньше :min символов.',
		'date' => 'Поле :attribute должно содержать корректную дату.',
		'url' => 'Поле :attribute должно содержать корректный URL адрес.',
		'in' => 'Поле :attribute должно иметь один из следующих типов: :values.',
		'alpha_dash' => 'Поле :attribute должно содержать только латинские символы, цифры, знаки подчёркивания (_) и дефисы (-).',
		'boolean' => 'Поле :attribute должно содержать булево значение.',

		'modeAccess.in' => 'Поле :attribute должно иметь один из следующих типов: :Наследовать, Свободный, Ограниченный.',
		];
	}

	/**
	 * Преобразователь атрибута - запись: название страницы.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setNamePageAttribute($value)
	{
	$this->attributes['namePage'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: ссылка на страницу.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setNameLinkAttribute($value)
	{
	$this->attributes['nameLink'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: описание страницы.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setDescriptionAttribute($value)
	{
	$this->attributes['description'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: ключевые слова.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setKeywordsAttribute($value)
	{
	$this->attributes['keywords'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: заголовок страницы.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setTitleAttribute($value)
	{
	$this->attributes['title'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: показывать в меню.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setShowInMenuAttribute($value)
	{
        switch($value)
        {
        case 'Показывать': $this->attributes['showInMenu'] = 1; break;
        case 'Не показывать': $this->attributes['showInMenu'] = 0; break;
        case 'Только в карте сайта': $this->attributes['showInMenu'] = 2; break;
        }
	}

	/**
	 * Преобразователь атрибута - получение: показывать в меню.
	 * @param mixed $value Значение атрибута.
	 * @return string Значение статуса.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getShowInMenuAttribute($value)
	{
        switch($value)
        {
        case 1: return 'Показывать'; break;
        case 0: return 'Не показывать'; break;
        case 2: return 'Только в карте сайта'; break;
        }

    return $value;
	}


	/**
	 * Преобразователь атрибута - запись: статус.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setModeAccessAttribute($value)
	{
		switch($value)
		{
		case 'Наследовать': $this->attributes['modeAccess'] = 'INHERIT'; break;
		case 'Свободный': $this->attributes['modeAccess'] = 'FREE'; break;
		case 'Ограниченный': $this->attributes['modeAccess'] = 'NOT FREE'; break;
		}
	}

	/**
	 * Преобразователь атрибута - получение: статус.
	 * @param mixed $value Значение атрибута.
	 * @return string Значение статуса.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getModeAccessAttribute($value)
	{
		switch($value)
		{
		case 'INHERIT': return 'Наследовать';
		case 'FREE': return 'Свободный';
		case 'NOT FREE': return 'Ограниченный';
		}

	return $value;
	}

	/**
	 * Преобразователь атрибута - запись: URL переадресации.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setToUrlAttribute($value)
	{
	$this->attributes['title'] = Util::getText($value);
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
	$this->attributes['status'] = Util::getStatus('number', $value);
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
	return Util::getStatus('label', $value);
	}


	/**
	 * Получить запись выбранных страниц группы.
	 * @return \App\Modules\User\Models\UserGroupPageEloquent Модель Выбранных страниц группы.
	 * @version 1.0
	 * @since 1.0
	 */
	public function UserGroupPage()
	{
	return $this->hasMany('App\Modules\User\Models\UserGroupPageEloquent', 'idPage');
	}

	/**
	 * Получить запись выбранных страниц роли.
	 * @return \App\Modules\User\Models\UserRolePageEloquent Модель Выбранных страниц роли.
	 * @version 1.0
	 * @since 1.0
	 */
	public function UserRolePage()
	{
	return $this->hasMany('App\Modules\User\Models\UserRolePageEloquent', 'idPage');
	}

	/**
	 * Получить запись шаблона страницы.
	 * @return \App\Modules\PageTemplate\Models\PageTemplateEloquent Модель Шаблона страницы.
	 * @version 1.0
	 * @since 1.0
	 */
	public function PageTemplate()
	{
    return $this->hasOne('App\Modules\PageTemplate\Models\PageTemplateEloquent', 'idPage', 'idPage');
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