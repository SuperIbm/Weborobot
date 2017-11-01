<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Models;

use Eloquent;
use App\Models\Validate;
use Util;
use Crypt;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы источников обновления на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idUploadSource ID записи.
 * @property string $login Логин.
 * @property string $password Пароль.
 * @property string $url URL источника обновления.
 * @property string $status Значение статуса.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Upload\Models\UploadSourceEloquent active($status = true)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Upload\Models\UploadSourceEloquent whereIdUploadSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Upload\Models\UploadSourceEloquent whereLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Upload\Models\UploadSourceEloquent wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Upload\Models\UploadSourceEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Upload\Models\UploadSourceEloquent whereUrl($value)
 *
 * @mixin \Eloquent
 */
class UploadSourceEloquent extends Eloquent
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
protected $table = 'uploadSource';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $primaryKey = 'idUploadSource';

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
'idUploadSource',
'login',
'password',
'url',
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
		'login' => 'required|between:1,255',
		'password' => 'required|between:1,255',
		'url' => 'url',
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
		'login' => 'Логин',
		'password' => 'Пароль',
		'url' => 'URL на ресурс',
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
		'max' => 'Поле :attribute должно содержать не больше :max символов.',
		'min' => 'Поле :attribute должно содержать не меньше :min символов.',
		'url' => 'Поле :attribute должно содержать корректный URL адрес.',
        'boolean' => 'Поле :attribute должно содержать булево значение.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: логин.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setLoginAttribute($value)
	{
	$this->attributes['login'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: пароль.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setPasswordAttribute($value)
	{
	$this->attributes['password'] = Crypt::encrypt($value);
	}

	/**
	 * Преобразователь атрибута - получение: пароль.
	 * @param mixed $value Значение атрибута.
	 * @return string расшифрованный пароль.
	 * @version 1.0
	 * @since 1.0
	 */
	public function getPasswordAttribute($value)
	{
	return Crypt::decrypt($value);
	}

	/**
	 * Преобразователь атрибута - запись: URL.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setUrlAttribute($value)
	{
	$this->attributes['url'] = Util::getText($value);
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
    $this->attributes['status'] = Util::getStatus("number", $value);
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
    return Util::getStatus("label", $value);
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
    return $Query->where($this->getTable().'.status', $status == true ? 1 : 0);
    }
}