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

/**
 * Класс модель для таблицы групп пользователей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idUserGroup
 * @property string $nameGroup
 * @property string $status Значение статуса.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupOfUserEloquent[] $UserGroupOfUser
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupRoleEloquent[] $UserGroupRole
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupPageEloquent[] $UserGroupPage
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupEloquent whereIdUserGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupEloquent whereNameGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupEloquent active($status = true)
 * 
 * @mixin \Eloquent
 */
class UserGroupEloquent extends Eloquent
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
protected $table = 'userGroup';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $primaryKey = 'idUserGroup';

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
'idUserGroup',
'nameGroup',
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
		'nameGroup' => 'required|between:1,100|unique:userGroup,nameGroup,'.$this->idUserGroup.',idUserGroup',
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
		'nameGroup' => 'Название группы',
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

		'nameGroup.unique' => 'Вы не можете добавить такую группу, т.к. он уже есть в базе данных.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: Название группы.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function setNameGroupAttribute($value)
	{
	$this->attributes['nameGroup'] = Util::getText($value);
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
	 * Получить запись выбранных групп.
	 * @return \App\Modules\User\Models\UserGroupOfUserEloquent Модель Группа выбранных групп.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserGroupOfUser()
	{
	return $this->hasMany('App\Modules\User\Models\UserGroupOfUserEloquent', 'idUserGroup');
	}

	/**
	 * Получить запись выбранных ролей.
	 * @return \App\Modules\User\Models\UserGroupRoleEloquent Модель выбранных ролей.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserGroupRole()
	{
	return $this->hasMany('App\Modules\User\Models\UserGroupRoleEloquent', 'idUserGroup');
	}

	/**
	 * Получить запись выбранных страниц группы.
	 * @return \App\Modules\User\Models\UserGroupPageEloquent Модель выбранных страницы для групп.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function UserGroupPage()
	{
	return $this->hasMany('App\Modules\User\Models\UserGroupPageEloquent', 'idUserGroup');
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