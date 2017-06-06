<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Models;

use App\Models\Tree\Arr\TreeArray;


/**
 * Класс модель для таблицы разделов публикаций с построением дерева в виде массива на основе Eloquent.
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
class PublicationSectionTreeArrayEloquent extends PublicationSectionEloquent
{
use TreeArray;

	/**
	 * Метод получения названия столбца определяющий название в узле.
	 * @return string Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameValue()
	{
	return "labelSection";
	}


	/**
	 * Метод получения названия столбца определяющий вес узла.
	 * @return string Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameWeight()
	{
	return "labelSection";
	}


	/**
	 * Метод получения объекта узла.
	 * @return \App\Models\Tree\Node Объект узла древовидной структуры.
	 * @since 1.0
	 * @version 1.0
	 */
	protected function _getNodeObject()
	{
	return new NodeArrayTextN();
	}

    /**
     * Определяет, нужно ли производить автоинкремент для веса узла.
     * @return bool Возвращает статус автоинкрементности.
     * @since 1.0
     * @version 1.0
     */
    public function getAutoIncrement()
    {
    return false;
    }
}