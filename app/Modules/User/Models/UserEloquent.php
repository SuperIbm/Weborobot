<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\User\Models;

use App\Models\Validate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Session;
use Util;
use Crypt;
use Image;


/**
 * Класс модель для таблицы пользователей на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * 
 * @property int $idUser
 * @property int $idImageSmall Маленькое изображение.
 * @property int $idImageMiddle Среднее изображение.
 * @property string $login Логин.
 * @property string $password Расшифрованный пароль.
 * @property string $remember_token Токен.
 * @property string $firstname Имя.
 * @property string $secondname Фамилия.
 * @property string $lastname Отчество.
 * @property string $email E-mail
 * @property string $telephone Телефон.
 * @property string $sex Пол.
 * @property \Carbon\Carbon $birthday Дата рождения.
 * @property string $icq ICQ.
 * @property string $skype Skype.
 * @property string $zip Индекс.
 * @property string $country Страна.
 * @property string $city Город.
 * @property string $street Адрес.
 * @property string $passportSeriaAndNumber Серия и номер паспорта.
 * @property string $passportWhoMade Паспорт выдан.
 * @property \Carbon\Carbon $passportWhenMade Дата выдачи паспорта.
 * @property string $passportCodeSection Код подразделения паспорта.
 * @property string $passportAdress Адрес прописки.
 * @property string $organForma Организационная форма.
 * @property string $organName Название организации.
 * @property string $organAbout Об организации.
 * @property string $site Сайт.
 * @property \Carbon\Carbon $dateAdd Дата регистрации.
 * @property \Carbon\Carbon $dateLastEnter Дата последнего входа.
 * @property string $ip IP адрес последнего входа.
 * @property string $status Значение статуса.
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupOfUserEloquent[] $UserGroupOfUser
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * 
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereIdUser($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereIdImageSmall($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereIdImageMiddle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereSecondname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereTelephone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereIcq($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereSkype($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent wherePassportSeriaAndNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent wherePassportWhoMade($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent wherePassportWhenMade($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent wherePassportCodeSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent wherePassportAdress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereOrganForma($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereOrganName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereOrganAbout($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereSite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereDateAdd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereDateLastEnter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserEloquent active($status = true)
 * @mixin \Eloquent
 */
class UserEloquent extends Authenticatable
{
use Validate, Notifiable;

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
protected $table = 'user';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $primaryKey = 'idUser';

/**
 * Определяет необходимость отметок времени для модели.
 * @var bool
 * @version 1.0
 * @since 1.0
 */
public $timestamps = false;

/**
 * Атрибуты, которые должны быть преобразованы к дате.
 * @var array
 * @version 1.0
 * @since 1.0
 */
protected $dates =
[
'birthday',
'dateAdd',
'dateLastEnter',
'passportWhenMade'
];

/**
 * Атрибуты, для которых разрешено массовое назначение.
 * @var array
 * @since 1.0
 * @version 1.0
 */
protected $fillable =
[
'idUser',
'idImageSmall',
'idImageMiddle',
'login',
'password',
'remember_token',
'firstname',
'secondname',
'lastname',
'email',
'telephone',
'sex',
'birthday',
'icq',
'skype',
'zip',
'country',
'city',
'street',
'passportSeriaAndNumber',
'passportWhoMade',
'passportWhenMade',
'passportCodeSection',
'passportAdress',
'organForma',
'organName',
'organAbout',
'site',
'dateAdd',
'dateLastEnter',
'ip',
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
		'idImageSmall' => 'integer|digits_between:0,20',
		'idImageMiddle' => 'integer|digits_between:0,20',
		'login' => 'required|between:1,50|unique:user,login,'.$this->idUser.',idUser',
		'password' => 'required',
		'remember_token',
		'firstname' => 'max:150',
		'secondname' => 'max:150',
		'lastname' => 'max:150',
		'email' => 'email',
		'telephone' => 'max:30',
		'sex' => 'max:20',
		'birthday' => 'date',
		'icq' => 'max:15',
		'skype' => 'max:150',
		'zip' => 'max:15',
		'country' => 'max:200',
		'city' => 'max:200',
		'street' => 'max:200',
		'passportSeriaAndNumber' => 'max:11',
		'passportWhoMade' => 'max:250',
		'passportWhenMade' => 'date',
		'passportCodeSection' => 'max:7',
		'passportAdress' => 'max:250',
		'organForma' => 'max:10',
		'organName' => 'max:250',
		'organAbout' => 'max:1000',
		'site' => 'url',
		'dateAdd' => 'required|date',
		'dateLastEnter' => 'date',
		'ip' => 'ip',
		'status' => 'required|min:0|max:2'
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
		'idImageSmall' => 'Маленькое изображение',
		'idImageMiddle' => 'Среднее изображение',
		'login' => 'Логин',
		'password' => 'Пароль',
		'remember_token' => 'Токен',
		'firstname' => 'Имя',
		'secondname' => 'Фамилия',
		'lastname' => 'Отчество',
		'email' => 'E-mail',
		'telephone' => 'Телефон',
		'sex' => 'Пол',
		'birthday' => 'Дата рождения',
		'icq' => 'ICQ',
		'skype' => 'Skype',
		'zip' => 'Индекс',
		'country' => 'Страна',
		'city' => 'Город',
		'street' => 'Уица',
		'passportSeriaAndNumber' => 'Cерсия и номер паспорта',
		'passportWhoMade' => 'Паспорт выдан',
		'passportWhenMade' => 'Дата выдачи паспорта',
		'passportCodeSection' => 'Код подразделения паспорта',
		'passportAdress' => 'Адрес прописки',
		'organForma' => 'Организационная форма',
		'organName' => 'Название организации',
		'organAbout' => 'Об организации',
		'site' => 'URL сайта',
		'dateAdd' => 'Дата добавления',
		'dateLastEnter' => 'Дата обнавления',
		'ip' => 'IP адрес',
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
		'email' => 'Поле :attribute должно содержать корректный email адрес.',
		'date' => 'Поле :attribute должно содержать корректную дату.',
		'url' => 'Поле :attribute должно содержать корректный URL адрес.',
		'ip' => 'Поле :attribute должно содержать корректный IP адрес.',
		'in' => 'Поле :attribute должно иметь один из следующих типов: :values.',
		'login.unique' => 'Вы не можете добавить такой логин, т.к. он уже есть в базе данных.'
		];
	}


	/**
	 * Определяем свойство, которое хранит значение в модели для канала отправки сообщения по средствам телефона.
	 * @return string
	 * @version 1.0
	 * @since 1.0
	 */
	public function routeNotificationForPhone()
	{
	return $this->telephone;
	}

	/**
	 * Определяем свойство, которое хранит значение в модели для канала отправки сообщения по средствам e-mail.
	 * @return string
	 * @version 1.0
	 * @since 1.0
	 */
	public function routeNotificationForMail()
	{
	return $this->email;
	}

	/**
	 * Определяем свойство, которое хранит значение в модели для канала отправки сообщения по средствам Nexmo.
	 * @return string
	 * @version 1.0
	 * @since 1.0
	 */
	public function routeNotificationForNexmo()
	{
	return $this->telephone;
	}

	/**
	 * Преобразователь атрибута - запись: маленькое изображение.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setIdImageSmallAttribute($value)
	{
        if(!$value) $this->attributes['idImageSmall'] = null;
		else if(is_array($value)) $this->attributes['idImageSmall'] = $value['idImage'];
		else if(is_numeric($value)) $this->attributes['idImageSmall'] = $value;
		else if(is_string($value))
		{
		$path = Image::cut($value, 60, 60);

			if(isset($this->attributes['idImageSmall'])) $id = Image::update($this->attributes['idImageSmall'], $path);
			else $id = Image::create($path);

			if($id !== false) $this->attributes['idImageSmall'] = $id;
		}
	}

	/**
	 * Преобразователь атрибута - получение: маленькое изображение.
	 * @param mixed $value Значение атрибута.
	 * @return array Маленькое изображение.
	 * @version 1.0
	 * @since 1.0
	 */
	public function getIdImageSmallAttribute($value)
	{
		if(is_numeric($value)) return Image::get($value);
		else return $value;
	}

	/**
	 * Преобразователь атрибута - запись: среднее изображение.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setIdImageMiddleAttribute($value)
	{
		if(!$value) $this->attributes['idImageMiddle'] = null;
	    else if(is_array($value)) $this->attributes['idImageMiddle'] = $value['idImage'];
		else if(is_numeric($value)) $this->attributes['idImageMiddle'] = $value;
		else if(is_string($value))
		{
		$path = Image::cut($value, 300, 300);

			if(isset($this->attributes['idImageMiddle'])) $id = Image::update($this->attributes['idImageMiddle'], $path);
			else $id = Image::create($path);

			if($id !== false) $this->attributes['idImageMiddle'] = $id;
		}
	}

	/**
	 * Преобразователь атрибута - получение: среднее изображение.
	 * @param mixed $value Значение атрибута.
	 * @return array Среднее изображение.
	 * @version 1.0
	 * @since 1.0
	 */
	public function getIdImageMiddleAttribute($value)
	{
		if(is_numeric($value)) return Image::get($value);
		else return $value;
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
	 * Преобразователь атрибута - запись: имя.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setFirstnameAttribute($value)
	{
	$this->attributes['firstname'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: фамилия.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setSecondnameAttribute($value)
	{
	$this->attributes['secondname'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: отчество.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setLastnameAttribute($value)
	{
	$this->attributes['lastname'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: e-mail.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setEmailAttribute($value)
	{
	$this->attributes['email'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: телефон.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setTelephoneAttribute($value)
	{
	$this->attributes['telephone'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: пол.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setSexAttribute($value)
	{
	$this->attributes['sex'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: icq.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setIcqAttribute($value)
	{
	$this->attributes['icq'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: skype.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setSkypeAttribute($value)
	{
	$this->attributes['skype'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: индекс.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setZipAttribute($value)
	{
	$this->attributes['zip'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: страна.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setCountryAttribute($value)
	{
	$this->attributes['country'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: город.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setCityAttribute($value)
	{
	$this->attributes['city'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: улица.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setStreetAttribute($value)
	{
	$this->attributes['street'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: серия и номер паспорта.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setPassportSeriaAndNumberAttribute($value)
	{
	$this->attributes['passportSeriaAndNumber'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: кто выдал паспорт.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setPassportWhoMadeAttribute($value)
	{
	$this->attributes['passportWhoMade'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: код подразделения паспорта.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setPassportCodeSectionAttribute($value)
	{
	$this->attributes['passportCodeSection'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: адрес прописки по паспорту.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 */
	public function setPassportAdressAttribute($value)
	{
	$this->attributes['passportAdress'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: организационная форма организации.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setOrganFormaAttribute($value)
	{
	$this->attributes['organForma'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: название организации.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setOrganNameAttribute($value)
	{
	$this->attributes['organName'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: название организации.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setOrganAboutAttribute($value)
	{
	$this->attributes['organAbout'] = Util::getTextBr($value);
	}

	/**
	 * Преобразователь атрибута - запись: сайт.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setSiteAttribute($value)
	{
	$this->attributes['site'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: IP.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function setIpAttribute($value)
	{
	$this->attributes['ip'] = Util::getText($value);
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
		switch($value)
		{
			case 'Активен': $this->attributes['status'] = 1; break;
			case 'Не активен': $this->attributes['status'] = 0; break;
			case 'Не подтвержден': $this->attributes['status'] = 2; break;

			case true: $this->attributes['status'] = 1; break;
			case false: $this->attributes['status'] = 0; break;
		}

		if($value < 0 && $value > 2) $this->attributes['status'] = $value;
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
		switch($value)
		{
			case 1: return 'Активен';
			case 0: return 'Не активен';
			case 2: return 'Не подтвержден';
		}

	return $value;
	}

	/**
	 * Получить запись выбранных групп для пользователя.
	 * @return \App\Modules\User\Models\UserGroupOfUserEloquent Модель выбраные группы для пользователей.
	 * @version 1.0
	 * @since 1.0
	 */
	public function UserGroupOfUser()
	{
	return $this->hasMany('App\Modules\User\Models\UserGroupOfUserEloquent', 'idUser');
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
		if($status == true) return $Query->where('status', 1);
		else
		{
			return $Query->orWhere
			(
				function($Query)
				{
					$Query
					->where('status', 0)
					->where('status', 2);
				}
			);
		}
	}


	/**
	 * Очитска всех сесиий после выхода.
	 * @return void
	 * @version 1.0
	 * @since 1.0
	 */
	public function out()
	{
	Session::forget('user');
	}
}