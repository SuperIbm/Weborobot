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
use Util;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы ролей пользователей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * 
 * @property int $idUserRole ID роли.
 * @property string $nameRole Название роли.
 * @property string $status Значение статуса.
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupRoleEloquent[] $UserGroupRole
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRoleAdminSectionEloquent[] $UserRoleAdminSection
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRolePageEloquent[] $UserRolePage
 * 
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleEloquent whereIdUserRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleEloquent whereNameRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleEloquent active($status = true)
 * 
 * @mixin \Eloquent
 */
class UserRoleEloquent extends Eloquent
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
protected $table = 'userRole';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $primaryKey = 'idUserRole';

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
'idUserRole',
'nameRole',
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
		'nameRole' => 'required|between:1,100|unique:userRole,nameRole,'.$this->idUserRole.',idUserRole',
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
		'nameRole' => 'Название роли',
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
		'between' => 'Поле :attribute должно быть длиней :min символов, но короче :max символов.',
		'boolean' => 'Поле :attribute должно содержать булево значение.',

		'nameRole.unique' => 'Вы не можете добавить такую роль, т.к. она уже есть в базе данных.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: Название роли.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function setNameRoleAttribute($value)
	{
	$this->attributes['nameRole'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: статус.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function setStatusAttribute($value)
	{
	$this->attributes['status'] = Util::getStatus("number", $value);
	}

	/**
	 * Преобразователь атрибута - получение: статус.
	 * @param mixed $value Значение атрибута.
	 * @return string Значение статуса.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function getStatusAttribute($value)
	{
	return Util::getStatus("label", $value);
	}


	/**
	 * Получить запись выбранных ролей.
	 * @return \App\Modules\User\Models\UserGroupRoleEloquent Модель выбранных ролей.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserGroupRole()
	{
	return $this->hasMany('App\Modules\User\Models\UserGroupRoleEloquent', 'idUserRole');
	}


	/**
	 * Получить запись выбранных разделов административной системы.
	 * @return \App\Modules\User\Models\UserRoleAdminSectionEloquent Модель выбранных разделов административной системы.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserRoleAdminSection()
	{
	return $this->hasMany('App\Modules\User\Models\UserRoleAdminSectionEloquent', 'idUserRole');
	}

	/**
	 * Получить запись выбранных страниц сайта.
	 * @return \App\Modules\User\Models\UserRolePageEloquent Модель выбранных страниц сайта.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserRolePage()
	{
	return $this->hasMany('App\Modules\User\Models\UserRolePageEloquent', 'idUserRole');
	}


	/**
	 * Заготовка запроса активных записей.
	 * @param \Illuminate\Database\Eloquent\Builder $Query Запрос.
	 * @param bool $status Статус активности.
	 * @return \Illuminate\Database\Eloquent\Builder Построитель запросов.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function scopeActive($Query, $status = true)
	{
	return $Query->where($this->getTable().'.status', $status == true ? 1 : 0);
	}
}