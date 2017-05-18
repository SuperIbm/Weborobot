<?php
/**
 * Модуль Временных изображений.
 * Этот модуль содержит все классы для работы с временными изображениями.
 * @package App.Modules.ImageTmp
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ImageTmp\Models;

use Eloquent;
use Image;
use Util;
use App\Models\Validate;


/**
 * Класс модель для таблицы временных изображений на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idImageTmp ID записи.
 * @property int $idImageSource Исходное изображение.
 * @property int $idImageThumbnail Превью изображения.
 * @property \Carbon\Carbon $dateAdd Дата добавления.
 * @property string $tags Тэги.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ImageTmp\Models\ImageTmpEloquent whereDateAdd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ImageTmp\Models\ImageTmpEloquent whereIdImageSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ImageTmp\Models\ImageTmpEloquent whereIdImageThumbnail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ImageTmp\Models\ImageTmpEloquent whereIdImageTmp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ImageTmp\Models\ImageTmpEloquent whereTags($value)
 *
 * @mixin \Eloquent
 */
class ImageTmpEloquent extends Eloquent
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
protected $table = 'imageTmp';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idImageTmp';

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
'idImageTmp',
'idImageSource',
'idImageThumbnail',
'dateAdd',
'tags'
];

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
	 * Метод, который должен вернуть все правила валидации.
	 * @version 1.0
	 * @since 1.0
	 */
	protected function getRules()
	{        
		return
		[
        'idImageSource' => 'required|integer|digits_between:1,20',
        'idImageThumbnail' => 'required|integer|digits_between:1,20',
        'dateAdd' => 'required|date',
        'tags' => 'max:255'
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
        'idImageSource' => 'Изображение источник',
        'idImageThumbnail' => 'Изображение превью',
        'dateAdd' => 'Дата добавления',
        'tags' => 'Тэги'
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
		'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.',
		'max' => 'Поле :attribute должно содержать не больше :max символов.',
        'date' => 'Поле :attribute должно содержать корректную дату.'
		];
	}

    /**
     * Преобразователь атрибута - запись: тэги.
     * @param mixed $value Значение атрибута.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function setTagsAttribute($value)
    {
    $this->attributes['tags'] = Util::getText($value);
    }

    /**
     * Преобразователь атрибута - запись: исходное изображение.
     * @param mixed $value Значение атрибута.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function setIdImageSourceAttribute($value)
    {
        if(!$value) $this->attributes['idImageSource'] = null;
        else if(is_array($value)) $this->attributes['idImageSource'] = $value['idImage'];
        else if(is_numeric($value)) $this->attributes['idImageSource'] = $value;
        else if(is_string($value))
        {
            if(isset($this->attributes['idImageSource'])) $id = Image::update($this->attributes['idImageSource'], $value);
            else $id = Image::create($value);

            if($id !== false) $this->attributes['idImageSource'] = $id;
        }
    }

    /**
     * Преобразователь атрибута - получение: исходное изображение.
     * @param mixed $value Значение атрибута.
     * @return array Маленькое изображение.
     * @version 1.0
     * @since 1.0
     */
    public function getIdImageSourceAttribute($value)
    {
        if(is_numeric($value)) return Image::get($value);
        else return $value;
    }

    /**
     * Преобразователь атрибута - запись: превью изображеня.
     * @param mixed $value Значение атрибута.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function setIdImageThumbnailAttribute($value)
    {
        if(!$value) $this->attributes['idImageThumbnail'] = null;
        else if(is_array($value)) $this->attributes['idImageThumbnail'] = $value['idImage'];
        else if(is_numeric($value)) $this->attributes['idImageThumbnail'] = $value;
        else if(is_string($value))
        {
            if(isset($this->attributes['idImageThumbnail'])) $id = Image::update($this->attributes['idImageThumbnail'], $value);
            else $id = Image::create($value);

            if($id !== false) $this->attributes['idImageThumbnail'] = $id;
        }
    }

    /**
     * Преобразователь атрибута - получение: превью изображеня.
     * @param mixed $value Значение атрибута.
     * @return array Маленькое изображение.
     * @version 1.0
     * @since 1.0
     */
    public function getIdImageThumbnailAttribute($value)
    {
        if(is_numeric($value)) return Image::get($value);
        else return $value;
    }
}