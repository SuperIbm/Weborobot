<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Models;

use Eloquent;
use Util;
use Image;
use Config;
use App\Models\Validate;

/**
 * Класс модель для таблицы комментариев в публикации на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idPublicationComment ID комментария публикации.
 * @property int $idPublication ID публикации.
 * @property int $idPublicationCommentReferen ID ссылки на родительский комментарий.
 * @property int $idUser ID пользователя комментатора.
 * @property string $name Имя пользователя комментатора.
 * @property string $email E-mail пользователя.
 * @property string $url URL сайта пользователя.
 * @property string $comment Комментарий.
 * @property \Carbon\Carbon $dateAdd Дата добавления.
 * @property string $ip IP пользователя.
 * @property string $status Статус.
 * @property int $idImageBig ID большого изображения.
 * @property int $idImageMiddle ID среднего изображения.
 * @property int $idImageSmall ID маленького изображения.
 *
 * @property-read \App\Modules\Publication\Models\PublicationEloquent $Publication
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent active($status = true)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereDateAdd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereIdImageBig($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereIdImageMiddle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereIdImageSmall($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereIdPublication($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereIdPublicationComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereIdPublicationCommentReferen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereIdUser($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationCommentEloquent whereUrl($value)
 *
 * @mixin \Eloquent
 */
class PublicationCommentEloquent extends Eloquent
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
protected $table = 'publicationComment';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idPublicationComment';

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
* @version 1.0
* @since 1.0
*/
protected $dates =
[
'dateAdd'
];

/**
 * Атрибуты, для которых разрешено массовое назначение.
 * @var array
 * @since 1.0
 * @version 1.0
 */
protected $fillable =
[
'idPublicationComment',
'idPublication',
'idPublicationCommentReferen',
'idUser',
'name',
'email',
'url',
'comment',
'dateAdd',
'ip',
'idImageBig',
'idImageMiddle',
'idImageSmall',
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
        'idPublication' => 'required|integer|digits_between:1,20',
        'idPublicationCommentReferen' => 'integer|max:20',
        'idUser' => 'integer|max:20',
        'name' => 'required|between:1,150',
        'email' => 'email',
        'url' => 'url',
        'comment' => 'required|between:1,5000',
        'dateAdd' => 'required|date',
        'ip' => 'ip',
        'idImageBig' => 'integer|digits_between:0,20',
        'idImageMiddle' => 'integer|digits_between:0,20',
        'idImageSmall' => 'integer|digits_between:0,20',
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
        'idPublication' => 'ID публикации',
        'idPublicationCommentReferen' => 'ID на родительский комментарий',
        'idUser' => 'ID пользователя',
        'name' => 'Имя пользователя',
        'email' => 'E-mail пользователя',
        'url' => 'URL на сайт пользователя',
        'comment' => 'Комментарий',
        'dateAdd' => 'Дата добавления',
        'ip' => 'IP пользователя',
        'idImageBig' => 'Большая картинка',
        'idImageMiddle' => 'Средняя картинка',
        'idImageSmall' => 'Маленькая картинка',
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
        'ip' => 'Поле :attribute должно содержать корректный IP адрес.'
        ];
	}

	/**
	 * Преобразователь атрибута - запись: имя пользователя.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setNameAttribute($value)
	{
	$this->attributes['name'] = Util::getText($value);
	}

    /**
     * Преобразователь атрибута - запись: e-mail пользователя.
     * @param mixed $value Значение атрибута.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setEmailAttribute($value)
    {
    $this->attributes['email'] = Util::getText($value);
    }

    /**
     * Преобразователь атрибута - запись: URL на сайт пользователя.
     * @param mixed $value Значение атрибута.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setUrlAttribute($value)
    {
    $this->attributes['url'] = Util::getText($value);
    }

    /**
     * Преобразователь атрибута - запись: Комментарий.
     * @param mixed $value Значение атрибута.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setCommentAttribute($value)
    {
    $this->attributes['comment'] = Util::getHtmlN($value);
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
        case 'Не проверен': $this->attributes['status'] = 2; break;

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
        case 2: return 'Не проверен';
        }

    return $value;
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
        $path = Image::cut($value, Config::get('publication.images.comment.small.width'), Config::get('publication.images.comment.small.height'));

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
        $path = Image::cut($value, Config::get('publication.images.comment.middle.width'), Config::get('publication.images.comment.middle.height'));

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
     * Преобразователь атрибута - запись: большое изображение.
     * @param mixed $value Значение атрибута.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function setIdImageBigAttribute($value)
    {
        if(!$value) $this->attributes['idImageBig'] = null;
        else if(is_array($value)) $this->attributes['idImageBig'] = $value['idImage'];
        else if(is_numeric($value)) $this->attributes['idImageBig'] = $value;
        else if(is_string($value))
        {
        $path = Image::cut($value, Config::get('publication.images.comment.big.width'), Config::get('publication.images.comment.big.height'));

            if(isset($this->attributes['idImageBig'])) $id = Image::update($this->attributes['idImageBig'], $path);
            else $id = Image::create($path);

            if($id !== false) $this->attributes['idImageBig'] = $id;
        }
    }

    /**
     * Преобразователь атрибута - получение: большое изображение.
     * @param mixed $value Значение атрибута.
     * @return array Большое изображение.
     * @version 1.0
     * @since 1.0
     */
    public function getIdImageBigAttribute($value)
    {
        if(is_numeric($value)) return Image::get($value);
        else return $value;
    }

    /**
     * Получить запись публикации.
     * @return \App\Modules\Publication\Models\PublicationEloquent Модель Пубиликации.
     * @version 1.0
     * @since 1.0
     */
    public function Publication()
    {
    return $this->belongsTo('App\Modules\Publication\Models\PublicationEloquent', 'idPublication');
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
}