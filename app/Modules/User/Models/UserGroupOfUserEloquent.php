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
 * Класс модель для таблицы выбранных групп для пользователя на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idUserGroupOfUser
 * @property int $idUserGroup
 * @property int $idUser
 *
 * @property-read \App\Modules\User\Models\UserEloquent $User
 * @property-read \App\Modules\User\Models\UserGroupEloquent $UserGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupRoleEloquent[] $UserGroupRole
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupOfUserEloquent whereIdUserGroupOfUser($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupOfUserEloquent whereIdUserGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupOfUserEloquent whereIdUser($value)
 *
 * @mixin \Eloquent
 */
class UserGroupOfUserEloquent extends Eloquent
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
protected $table = 'userGroupOfUser';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $primaryKey = 'idUserGroupOfUser';

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
'idUserGroupOfUser',
'idUserGroup',
'idUser'
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
		'idUser' => 'required|integer|digits_between:1,20'
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
		'idUser' => 'ID пользователя'
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
	 * Получить запись пользователя.
	 * @return \App\Modules\User\Models\UserEloquent Модель Пользователь.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function User()
	{
	return $this->belongsTo('App\Modules\User\Models\UserEloquent', 'idUser');
	}


	/**
	 * Получить запись группы.
	 * @return \App\Modules\User\Models\UserGroupEloquent Модель Группа пользователей.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserGroup()
	{
	return $this->hasMany('App\Modules\User\Models\UserGroupEloquent', 'idUserGroup', 'idUserGroup');
	}


	/**
	 * Получить выбранные роли для группы.
	 * @return \App\Modules\User\Models\UserGroupRoleEloquent Модель выбранные роли для группы.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserGroupRole()
	{
	return $this->hasMany('App\Modules\User\Models\UserGroupRoleEloquent', 'idUserGroup', 'idUserGroup');
	}
}