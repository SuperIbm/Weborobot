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
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы выбранных страниц роли на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * 
 * @property int $idUserRolePage
 * @property int $idUserRole
 * @property int $idPage
 * 
 * @property-read \App\Modules\User\Models\UserRoleEloquent $UserRole
 * @property-read \App\Modules\Page\Models\PageEloquent $Page
 * 
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRolePageEloquent whereIdUserRolePage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRolePageEloquent whereIdUserRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRolePageEloquent whereIdPage($value)
 * 
 * @mixin \Eloquent
 */
class UserRolePageEloquent extends Eloquent
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
protected $table = 'userRolePage';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 */
protected $primaryKey = 'idUserRolePage';

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
'idUserRolePage',
'idUserRole',
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
		'idUserRole' => 'required|integer|digits_between:1,20',
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
		'idUserRole' => 'ID пользовательской роли',
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
	 * Получить запись роли.
	 * @return \App\Modules\User\Models\UserRoleEloquent Модель роли пользователей.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserRole()
	{
	return $this->belongsTo('App\Modules\User\Models\UserRoleEloquent', 'idUserRole');
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