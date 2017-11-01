<?php
/**
 * Модуль Шаблоны модуля.
 * Этот модуль содержит все классы для работы с шаблонами модулей системы.
 * @package App.Modules.ModuleTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ModuleTemplate\Models;

use Eloquent;
use Util;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы шаблонов модулей на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * 
 * @property int $idModuleTemplate ID шаблона модуля.
 * @property int $idModule ID модуля.
 * @property string $labelTemplate Название шаблона.
 * @property string $htmlTpl HTML шаблона. 
 * @property string $status Значение статуса.
 * 
 * @property-read \App\Modules\Module\Models\ModuleEloquent $Module
 * 
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent whereIdModuleTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent whereIdModule($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent whereLabelTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent whereHtmlTpl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent active($status = true)
 * 
 * @mixin \Eloquent
 */
class ModuleTemplateEloquent extends Eloquent
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
protected $table = 'moduleTemplate';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idModuleTemplate';

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
'idModuleTemplate',
'idModule',
'labelTemplate',
'htmlTpl',
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
		'idModule' => 'required|integer|digits_between:1,20',
		'labelTemplate' => 'required|between:1,150',
		'htmlTpl' => 'between:0,65000',
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
		'idModule' => 'ID модуля',
		'labelSection' => 'Название шаблона',
		'htmlTpl' => 'Код шаблона',
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
		];
	}

	/**
	 * Преобразователь атрибута - запись: название шаблона.
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
	 * Преобразователь атрибута - запись: название шаблона.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setHtmlTplAttribute($value)
	{
	$this->attributes['htmlTpl'] = Util::getHtmlN($value);
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
	 * Получить запись модуля.
	 * @return \App\Modules\Module\Models\ModuleEloquent Модель Модуля.
	 * @version 1.0
	 * @since 1.0
	 */
	public function Module()
	{
	return $this->hasOne('App\Modules\Module\Models\ModuleEloquent', 'idModule', 'idModule');
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