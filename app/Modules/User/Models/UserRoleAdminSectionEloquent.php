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
 * Класс модель для таблицы выбранных разделов роли на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * 
 * @property int $idUserRoleAdminSection
 * @property int $idUserRole
 * @property int $idAdminSection
 * @property bool $isRead Значение статуса на чтение.
 * @property bool $isUpdate Значение статуса на обновление.
 * @property bool $isCreate Значение статуса на создание.
 * @property bool $isDestroy Значение статуса на удаление.
 * 
 * @property-read \App\Modules\User\Models\UserRoleEloquent $UserRole
 * @property-read \App\Modules\AdminSection\Models\AdminSectionEloquent $AdminSection
 * 
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSectionEloquent whereIdUserRoleAdminSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSectionEloquent whereIdUserRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSectionEloquent whereIdAdminSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSectionEloquent whereIsRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSectionEloquent whereIsUpdate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSectionEloquent whereIsCreate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSectionEloquent whereIsDestroy($value)
 * 
 * @mixin \Eloquent
 */
class UserRoleAdminSectionEloquent extends Eloquent
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
protected $table = 'userRoleAdminSection';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $primaryKey = 'idUserRoleAdminSection';

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
'idUserRoleAdminSection',
'idUserRole',
'idAdminSection',
'isRead',
'isUpdate',
'isCreate',
'isDestroy'
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
		'idAdminSection' => 'required|integer|digits_between:1,20',
		'isRead' => 'required|boolean',
		'isUpdate' => 'required|boolean',
		'isCreate' => 'required|boolean',
		'isDestroy' => 'required|boolean'
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
		'idAdminSection' => 'ID раздела административной системы',
		'isRead' => 'Доступ на чтение',
		'isUpdate' => 'Доступ на обновление',
		'isCreate' => 'Доступ на создание',
		'isDestroy' => 'Доступ на удаление'
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
	 * Преобразователь атрибута - запись: доступ на чтение.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function setIsReadAttribute($value)
	{
	$this->attributes['isRead'] = Util::getBool("number", $value);
	}

	/**
	 * Преобразователь атрибута - получение: доступ на чтение.
	 * @param mixed $value Значение атрибута.
	 * @return string Значение статуса на чтение.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function getIsReadAttribute($value)
	{
	return Util::getBool("label", $value);
	}

	/**
	 * Преобразователь атрибута - запись: доступ на обновление.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function setIsUpdateAttribute($value)
	{
	$this->attributes['isUpdate'] = Util::getBool("number", $value);
	}

	/**
	 * Преобразователь атрибута - получение: доступ на обновление.
	 * @param mixed $value Значение атрибута.
	 * @return string Значение статуса на обновление.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function getIsUpdateAttribute($value)
	{
	return Util::getBool("label", $value);
	}

	/**
	 * Преобразователь атрибута - запись: доступ на добавление.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function setIsCreateAttribute($value)
	{
	$this->attributes['isCreate'] = Util::getBool("number", $value);
	}

	/**
	 * Преобразователь атрибута - получение: доступ на добавление.
	 * @param mixed $value Значение атрибута.
	 * @return string Значение статуса на создание.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function getIsCreateAttribute($value)
	{
	return Util::getBool("label", $value);
	}

	/**
	 * Преобразователь атрибута - запись: доступ на удаление.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
 	 * @since 1.0
	 */
	public function setIsDestroyAttribute($value)
	{
	$this->attributes['isDestroy'] = Util::getBool("number", $value);
	}

	/**
	 * Преобразователь атрибута - получение: доступ на удаление.
	 * @param mixed $value Значение атрибута.
	 * @return string Значение статуса на удаление.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function getIsDestroyAttribute($value)
	{
	return Util::getBool("label", $value);
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
	 * Получить раздел адмнистративной системы.
	 * @return \App\Modules\AdminSection\Models\AdminSectionEloquent Модель разделов административной системы.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function AdminSection()
	{
	return $this->belongsTo('App\Modules\AdminSection\Models\AdminSectionEloquent', 'idAdminSection');
	}
}