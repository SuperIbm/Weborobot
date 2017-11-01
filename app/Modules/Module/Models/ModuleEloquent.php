<?php
/**
 * Модуль "Модулей".
 * Этот модуль содержит все классы для работы с модулями.
 * @package App.Modules.Module
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Module\Models;

use Eloquent;
use Util;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы модулей на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $idModule ID модуля.
 * @property string $nameModule Название модуля.
 * @property string $labelModule Метка модуля.
 * @property string $status Значение статуса.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent[] $ModuleTemplate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Component\Models\ComponentEloquent[] $Component
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AdminSection\Models\AdminSectionEloquent $AdminSection
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Module\Models\ModuleEloquent whereIdModule($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Module\Models\ModuleEloquent whereNameModule($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Module\Models\ModuleEloquent whereLabelModule($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Module\Models\ModuleEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Module\Models\ModuleEloquent active($status = true)
 *
 * @mixin \Eloquent
 */
class ModuleEloquent extends Eloquent
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
protected $table = 'module';

/**
 * Связанная с моделью первичный ключь.
 * @var string
 * @since 1.0
 * @version 1.0
 */
protected $primaryKey = 'idModule';

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
'idModule',
'nameModule',
'labelModule',
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
		'nameModule' => 'required|between:1,150|unique:Module,nameModule,'.$this->idModule.',idModule',
		'labelModule' => 'required|between:1,150',
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
		'nameModule' => 'Название модуля',
		'labelModule' => 'Лейбел модуля',
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
		'boolean' => 'Поле :attribute должно содержать булево значение.',

		'nameModule.unique' => 'Вы не можете добавить такой модуль, т.к. он уже есть в базе данных.'
		];
	}

	/**
	 * Преобразователь атрибута - запись: название модуля.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setNameModuleAttribute($value)
	{
	$this->attributes['nameModule'] = Util::getText($value);
	}

	/**
	 * Преобразователь атрибута - запись: лейбел модуля.
	 * @param mixed $value Значение атрибута.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function setLabelModuleAttribute($value)
	{
	$this->attributes['labelModule'] = Util::getText($value);
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
	 * Получить запись шаблонов модуля.
	 * @return \App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent Модель шаблонов модуля.
	 * @version 1.0
	 * @since 1.0
	 */
	public function ModuleTemplate()
	{
	return $this->hasMany('App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent', 'idModule');
	}

	/**
	 * Получить запись компонентов модуля.
	 * @return \App\Modules\Component\Models\ComponentEloquent Модель компонетов модуля.
	 * @version 1.0
	 * @since 1.0
	 */
	public function Component()
	{
    return $this->hasMany('App\Modules\Component\Models\ComponentEloquent', 'idModule');
	}

    /**
     * Получить запись раздела административной системы.
     * @return \App\Modules\AdminSection\Models\AdminSectionEloquent Модель компонетов модуля.
     * @version 1.0
     * @since 1.0
     */
    public function AdminSection()
    {
    return $this->hasOne('App\Modules\AdminSection\Models\AdminSectionEloquent', 'idModule', 'idModule');
    }

    /**
     * Получить запись модуля.
     * @return \App\Modules\Upload\Models\UploadEloquent Модель обновления.
     * @version 1.0
     * @since 1.0
     */
    public function Upload()
    {
    return $this->hasOne('App\Modules\Upload\Models\UploadEloquent', 'idModule', 'idModule');
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