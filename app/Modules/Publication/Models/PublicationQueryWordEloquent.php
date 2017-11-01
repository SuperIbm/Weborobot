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
 * Класс модель для таблицы ключевых фраз в публикации на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idPublicationQueryWord ID ключевого слова.
 * @property int $idPublication ID публикации.
 * @property string $queryWord Ключевое слово.
 *
 * @property-read \App\Modules\Publication\Models\PublicationEloquent $Publication
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationQueryWordEloquent whereIdPublication($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationQueryWordEloquent whereIdPublicationQueryWord($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Publication\Models\PublicationQueryWordEloquent whereQueryWord($value)
 *
 * @mixin \Eloquent
 */
class PublicationQueryWordEloquent extends Eloquent
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
protected $table = 'publicationQueryWord';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idPublicationQueryWord';

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
'idPublicationQueryWord',
'idPublication',
'queryWord'
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
        'queryWord' => 'required|between:1,150'
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
        'queryWord' => 'Ключевое слово'
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
        'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.'
        ];
	}

	/**
	 * Преобразователь атрибута - запись: ключевое слово.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setQueryWordAttribute($value)
	{
	$this->attributes['queryWord'] = Util::getText($value);
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
}