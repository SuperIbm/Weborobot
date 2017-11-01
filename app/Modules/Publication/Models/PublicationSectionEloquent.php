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
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы разделов публикаций на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idPublicationSection ID раздела публикации.
 * @property string $labelSection Название раздела.
 * @property string $status Статус.
 * @property int $imageBigWidth Ширина большого изображения.
 * @property int $imageBigHeight Высота большого изображения.
 * @property int $imageMiddleWidth Ширина среднего изображения.
 * @property int $imageMiddleHeight Высота среднего изображения.
 * @property int $imageSmallWidth Ширина маленького изображения.
 * @property int $imageSmallHeight Высота маленького изображения.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Publication\Models\PublicationEloquent[] $Publication
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationSectionEloquent active($status = true)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationSectionTreeArrayEloquent whereIdPublicationSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationSectionTreeArrayEloquent whereImageBigHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationSectionTreeArrayEloquent whereImageBigWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationSectionTreeArrayEloquent whereImageMiddleHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationSectionTreeArrayEloquent whereImageMiddleWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationSectionTreeArrayEloquent whereImageSmallHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationSectionTreeArrayEloquent whereImageSmallWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationSectionTreeArrayEloquent whereLabelSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationSectionTreeArrayEloquent whereStatus($value)
 *
 * @mixin \Eloquent
 */
class PublicationSectionEloquent extends Eloquent
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
protected $table = 'publicationSection';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idPublicationSection';

/**
 * Определяет необходимость отметок времени для модели.
 * @var bool
 * @since 1.0
 * @version 1.0
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
'idPublicationSection',
'labelSection',
'imageBigWidth',
'imageBigHeight',
'imageMiddleWidth',
'imageMiddleHeight',
'imageSmallWidth',
'imageSmallHeight',
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
        'labelSection' => 'required|between:1,150|unique:publicationSection,labelSection,'.$this->idPublicationSection.',idPublicationSection',
        'imageBigWidth' => 'required|integer|digits_between:1,4',
        'imageBigHeight' => 'required|integer|digits_between:1,4',
        'imageMiddleWidth' => 'required|integer|digits_between:1,4',
        'imageMiddleHeight' => 'required|integer|digits_between:1,4',
        'imageSmallWidth' => 'required|integer|digits_between:1,4',
        'imageSmallHeight' => 'required|integer|digits_between:1,4',
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
        'labelSection' => 'Название секции',
        'imageBigWidth' => 'Ширина большого изображения',
        'imageBigHeight' => 'Высота большого изображения',
        'imageMiddleWidth' => 'Ширина среднего изображения',
        'imageMiddleHeight' => 'Высота среднего изображения',
        'imageSmallWidth' => 'Ширина маленького изображения',
        'imageSmallHeight' => 'Высота маленького изображения',
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
        'date' => 'Поле :attribute должно содержать корректную дату.',
        'boolean' => 'Поле :attribute должно содержать булево значение.',
        'labelSection.unique' => 'Вы не можете добавить такой логин, т.к. он уже есть в базе данных.'
        ];
	}

	/**
	 * Преобразователь атрибута - запись: название секции.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setLabelSectionAttribute($value)
	{
	$this->attributes['labelSection'] = Util::getText($value);
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
     * Получить записи пубикаций.
     * @return \App\Modules\Publication\Models\PublicationEloquent Модель Публикации.
     * @version 1.0
     * @since 1.0
     */
    public function Publication()
    {
    return $this->hasMany('App\Modules\Publication\Models\PublicationEloquent', 'idPublicationSection');
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