<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Models;

use App\Models\Tree\Str\TreeString;


/**
 * Класс модель для таблицы комментариев публикации с построением дерева в виде строки на основе Eloquent.
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
class PublicationCommentTreeStringEloquent extends PublicationCommentEloquent
{
use TreeString;

	/**
	 * Метод получения названия столбца определяющий название в узле.
	 * @return string Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameValue()
	{
	return "name";
	}

    /**
     * Получение названия столбца определяющего ID ссылки на предыдущий узел.
     * @return string Возвращает название столбца.
     * @since 1.0
     * @version 1.0
     */
    public static function getNameReferen()
    {
    return "idPublicationCommentReferen";
    }

	/**
	 * Метод получения названия столбца определяющий вес узла.
	 * @return string|array Возвращает название столбца.
	 * @since 1.0
	 * @version 1.0
	 */
	public static function getNameWeight()
	{
	    return
        [
            [
            'property' => 'dateAdd',
            'direction' => 'ASC'
            ],
            [
            'property' => 'publicationComment.idPublicationComment',
            'direction' => 'ASC'
            ],
        ];
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