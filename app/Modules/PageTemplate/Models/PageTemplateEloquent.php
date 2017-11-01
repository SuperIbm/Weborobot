<?php
/**
 * Модуль Шаблоны для страниц.
 * Этот модуль содержит все классы для работы с шаблонами для страниц.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageTemplate\Models;

use Eloquent;
use Util;
use Image;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы шаблонов страниц на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * 
 * @property int $idPageTemplate ID шаблона страницы.
 * @property string $labelTemplate Лейбел шаблона.
 * @property string $nameTemplate Название шаблона.
 * @property int $countBlocks Количество блоков в шаблоне.
 * @property int $idImage Изображение шаблона.
 * @property string $status Значение статуса.
 * 
 * @property-read \App\Modules\Page\Models\PageEloquent $PageTemplate
 * 
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageTemplate\Models\PageTemplateEloquent whereIdPageTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageTemplate\Models\PageTemplateEloquent whereLabelTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageTemplate\Models\PageTemplateEloquent whereNameTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageTemplate\Models\PageTemplateEloquent whereCountBlocks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageTemplate\Models\PageTemplateEloquent whereIdImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageTemplate\Models\PageTemplateEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\PageTemplate\Models\PageTemplateEloquent active($status = true)
 * 
 * @mixin \Eloquent
 */
class PageTemplateEloquent extends Eloquent
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
protected $table = 'pageTemplate';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idPageTemplate';

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
'idPageTemplate',
'labelTemplate',
'nameTemplate',
'countBlocks',
'idImage',
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
        'labelTemplate' => 'required|between:1,150|unique:pageTemplate,labelTemplate,'.$this->idPageTemplate.',idPageTemplate',
        'nameTemplate' => 'required|between:1,150',
        'countBlocks' => 'required|digits_between:1,5',
        'idImage' => 'integer|digits_between:1,5',
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
        'labelTemplate' => 'Лейбел шаблона',
        'nameTemplate' => 'Название шаблона',
        'countBlocks' => 'Количество блоков',
        'idImage' => 'Изображение шаблона',
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
		'boolean' => 'Поле :attribute должно содержать булево значение.',
		'labelTemplate.unique' => 'Вы не можете добавить шаблон с таким названием, т.к. он уже есть в базе данных.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: Лейбел шаблона.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setLabelTemplateAttribute($value)
	{
	$this->attributes['labelTemplate'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: Название шаблона.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setNameTemplateAttribute($value)
	{
	$this->attributes['nameTemplate'] = Util::getText($value);
	}

    /**
     * Преобразователь атрибута - запись: изображение шаблона.
     * @param mixed $value Значение атрибута.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function setIdImageAttribute($value)
    {
        if(!$value) $this->attributes['idImage'] = null;
        else if(is_array($value)) $this->attributes['idImage'] = $value['idImage'];
        else if(is_numeric($value)) $this->attributes['idImage'] = $value;
        else if(is_string($value))
        {
            $path = Image::cut($value, 170);

            if(isset($this->attributes['idImage'])) $id = Image::update($this->attributes['idImage'], $path);
            else $id = Image::create($path);

            if($id !== false) $this->attributes['idImage'] = $id;
        }
    }

    /**
     * Преобразователь атрибута - получение: изображение шаблона.
     * @param mixed $value Значение атрибута.
     * @return array Маленькое изображение.
     * @version 1.0
     * @since 1.0
     */
    public function getIdImageAttribute($value)
    {
        if(is_numeric($value)) return Image::get($value);
        else return $value;
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
     * Получить запись страницы.
     * @return \App\Modules\Page\Models\PageEloquent Модель Страницы сайта.
     * @version 1.0
     * @since 1.0
     */
    public function PageTemplate()
    {
    return $this->belongsTo('App\Modules\Page\Models\PageEloquent', 'idPageTemplate', 'idPageTemplate');
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