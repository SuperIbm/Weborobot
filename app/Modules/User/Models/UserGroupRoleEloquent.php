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
 * Класс модель для таблицы выбранных ролей группы на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * 
 * @property-read \App\Modules\User\Models\UserGroupEloquent $UserGroup
 * @property-read \App\Modules\User\Models\UserRoleEloquent $UserRole
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRoleAdminSectionEloquent[] $UserRoleAdminSection
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRolePageEloquent[] $UserRolePage
 * 
 * @mixin \Eloquent
 */
class UserGroupRoleEloquent extends Eloquent
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
protected $table = 'userGroupRole';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $primaryKey = 'idUserGroupRole';

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
'idUserGroupRole',
'idUserGroup',
'idUserRole'
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
		'idUserRole' => 'required|integer|digits_between:1,20'
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
		'idUserRole' => 'ID пользовательской роли'
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
	 * Получить запись группы.
	 * @return \App\Modules\User\Models\UserGroupEloquent Модель Группа пользователей.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserGroup()
	{
	return $this->belongsTo('App\Modules\User\Models\UserGroupEloquent', 'idUserGroup');
	}

	/**
	 * Получить запись роли.
	 * @return \App\Modules\User\Models\UserRoleEloquent Модель Роли пользователей.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserRole()
	{
	return $this->belongsTo('App\Modules\User\Models\UserRoleEloquent', 'idUserRole');
	}

	/**
	 * Получить выбранные разделы административной системы для роли.
	 * @return \App\Modules\User\Models\UserRoleAdminSectionEloquent Модель выбранных разделов административной системы для роли.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserRoleAdminSection()
	{
	return $this->hasMany('App\Modules\User\Models\UserRoleAdminSectionEloquent', 'idUserRole', 'idUserRole');
	}

	/**
	 * Получить запись выбранных страниц сайта.
	 * @return \App\Modules\User\Models\UserRoleAdminSectionEloquent Модель выбранных страниц сайта.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserRolePage()
	{
	return $this->hasMany('App\Modules\User\Models\UserRolePageEloquent', 'idUserRole', 'idUserRole');
	}
}