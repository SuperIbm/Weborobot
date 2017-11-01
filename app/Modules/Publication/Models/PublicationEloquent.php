<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Models;

use App;
use Eloquent;
use Util;
use Image;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы публикаций на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idPublication ID публикации.
 * @property int $idPublicationSection ID раздела публикации.
 * @property \Carbon\Carbon $dateAdd Дата добавления.
 * @property string $title Заголовок статьи.
 * @property string $link Ссылка на статью.
 * @property string $anons Анонс.
 * @property string $textOfArticle Текст статьи.
 * @property string $status Статус.
 * @property int $idImageBig
 * @property int $idImageMiddle
 * @property int $idImageSmall
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Publication\Models\PublicationCommentEloquent[] $PublicationComment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Publication\Models\PublicationQueryWordEloquent[] $PublicationQueryWord
 * @property-read \App\Modules\Publication\Models\PublicationSectionEloquent $PublicationSection
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent active($status = true)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereAnons($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereDateAdd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereIdImageBig($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereIdImageMiddle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereIdImageSmall($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereIdPublication($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereIdPublicationSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereTextOfArticle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationEloquent whereTitle($value)
 *
 * @mixin \Eloquent
 */
class PublicationEloquent extends Eloquent
{
use Validate, SoftDeletes;
    
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
protected $table = 'publication';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idPublication';

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
'idPublication',
'idPublicationSection',
'dateAdd',
'title',
'link',
'anons',
'textOfArticle',
'status',
'idImageBig',
'idImageMiddle',
'idImageSmall'
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
        'idPublicationSection' => 'required|integer|digits_between:1,20',
        'dateAdd' => 'required|date',
        'title' => 'required|between:1,255',
        'link' => 'required|between:1,255|alpha_dash',
        'anons' => 'max:1000',
        'textOfArticle' => 'max:65000',
        'idImageBig' => 'integer|digits_between:0,20',
        'idImageMiddle' => 'integer|digits_between:0,20',
        'idImageSmall' => 'integer|digits_between:0,20',
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
        'idPublicationSection' => 'ID секции',
        'dateAdd' => 'Дата добавления',
        'title' => 'Заголовок статьи',
        'link' => 'Ссылка на статью',
        'anons' => 'Анонс',
        'textOfArticle' => 'Текст статьи',
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
        'date' => 'Поле :attribute должно содержать корректную дату.',
        'boolean' => 'Поле :attribute должно содержать булево значение.',
        'alpha_dash' => 'Поле :attribute должно содержать только латинские символы, цифры, знаки подчёркивания (_) и дефисы (-).'
        ];
	}

	/**
	 * Преобразователь атрибута - запись: заголовок статьи.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setTitleAttribute($value)
	{
	$this->attributes['title'] = Util::getText($value);
	}

    /**
     * Преобразователь атрибута - запись: ссылка на статью.
     * @param mixed $value Значение атрибута.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setLinkAttribute($value)
    {
    $this->attributes['link'] = Util::getText($value);
    }

    /**
     * Преобразователь атрибута - запись: анонс.
     * @param mixed $value Значение атрибута.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setAnonsAttribute($value)
    {
    $this->attributes['anons'] = Util::getTextBr($value);
    }

	/**
	 * Преобразователь атрибута - запись: текст статьи.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setTextOfArticleAttribute($value)
	{
	$this->attributes['textOfArticle'] = Util::getHtmlN($value);
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
        $section = App::make('App\Modules\Publication\Repositories\PublicationSection')->get($this->attributes['idPublicationSection']);

            if($section)
            {
            $path = Image::cut($value, $section['imageSmallWidth'], $section['imageSmallHeight']);

                if(isset($this->attributes['idImageSmall'])) $id = Image::update($this->attributes['idImageSmall'], $path);
                else $id = Image::create($path);

            if($id !== false) $this->attributes['idImageSmall'] = $id;
            }
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
        $section = App::make('App\Modules\Publication\Repositories\PublicationSection')->get($this->attributes['idPublicationSection']);

            if($section)
            {
            $path = Image::cut($value, $section['imageMiddleWidth'], $section['imageMiddleHeight']);

                if(isset($this->attributes['idImageMiddle'])) $id = Image::update($this->attributes['idImageMiddle'], $path);
                else $id = Image::create($path);

                if($id !== false) $this->attributes['idImageMiddle'] = $id;
            }
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
        $section = App::make('App\Modules\Publication\Repositories\PublicationSection')->get($this->attributes['idPublicationSection']);

            if($section)
            {
            $path = Image::cut($value, $section['imageBigWidth'], $section['imageBigHeight']);

                if(isset($this->attributes['idImageBig'])) $id = Image::update($this->attributes['idImageBig'], $path);
                else $id = Image::create($path);

                if($id !== false) $this->attributes['idImageBig'] = $id;
            }
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
     * Получить запись раздела публикации.
     * @return \App\Modules\Publication\Models\PublicationSectionEloquent Модель Раздел пубиликаций.
     * @version 1.0
     * @since 1.0
     */
    public function PublicationSection()
    {
    return $this->belongsTo('App\Modules\Publication\Models\PublicationSectionEloquent', 'idPublicationSection');
    }

    /**
     * Получить записи ключевые слова публикации.
     * @return \App\Modules\Publication\Models\PublicationQueryWordEloquent Модель Ключевые слова публикации.
     * @version 1.0
     * @since 1.0
     */
    public function PublicationQueryWord()
    {
    return $this->hasMany('App\Modules\Publication\Models\PublicationQueryWordEloquent', 'idPublication');
    }

    /**
     * Получить записи комментариев.
     * @return \App\Modules\Publication\Models\PublicationCommentEloquent Модель Комметарии.
     * @version 1.0
     * @since 1.0
     */
    public function PublicationComment()
    {
    return $this->hasMany('App\Modules\Publication\Models\PublicationCommentEloquent', 'idPublication');
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