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
use App\Models\Validate;

/**
 * Класс модель для таблицы выбранных страницы группы на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * @property-read \App\Modules\User\Models\UserGroupEloquent $UserGroup
 * @property-read \App\Modules\Page\Models\PageEloquent $User
 * @property-read \App\Modules\Page\Models\PageEloquent $Page
 * @mixin \Eloquent
 */
class UserGroupPageEloquent extends Eloquent
{
use Validate;
    
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
protected $table = 'userGroupPage';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $primaryKey = 'idUserGroupPage';

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
'idUserGroupPage',
'idUserGroup',
'idPage'
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
		'idUserGroup' => 'required|integer|digits_between:1,20',
		'idPage' => 'required|integer|digits_between:1,20'
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
		'idUserGroup' => 'ID пользовательской группы',
		'idPage' => 'ID страницы'
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
		'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.',
		'integer' => 'Поле :attribute должно содержать число.'
		];
	}

	/**
	 * Получить запись группы пользователя.
	 * @return \App\Modules\User\Models\UserGroupEloquent Модель группа пользователя.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserGroup()
	{
	return $this->belongsTo('App\Modules\User\Models\UserGroupEloquent', 'idUserGroup');
	}

	/**
	 * Получить запись страница сайта.
	 * @return \App\Modules\Page\Models\PageEloquent Модель страницы сайта.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function User()
	{
	return $this->belongsTo('App\Modules\Page\Models\PageEloquent', 'idPage');
	}


	/**
	 * Получить страницы сайта.
	 * @return \App\Modules\Page\Models\PageEloquent Модель страниц сайта.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function Page()
	{
	return $this->belongsTo('App\Modules\Page\Models\PageEloquent', 'idPage');
	}
}