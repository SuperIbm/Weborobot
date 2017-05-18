<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Modules\Alias\Models{
/**
 * Класс модель для таблицы псевдонимов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * @property int $idAlias
 * @property string $pattern
 * @property int $idPage
 * @property string Значение статуса. $status
 * @property-read \App\Modules\Page\Models\PageEloquent $Page
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alias\Models\AliasEloquent whereIdAlias($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alias\Models\AliasEloquent wherePattern($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alias\Models\AliasEloquent whereIdPage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alias\Models\AliasEloquent whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alias\Models\AliasEloquent active($status = true)
 */
	class AliasEloquent extends \Eloquent {}
}

